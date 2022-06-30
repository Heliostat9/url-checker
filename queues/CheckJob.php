<?php

namespace app\queues;

use app\models\Checks;
use Yii;
use yii\base\BaseObject;
use yii\db\Expression;
use yii\queue\JobInterface;

class CheckJob extends BaseObject implements JobInterface
{
    public $urlId;
    public $frequency;
    public $repeats;
    public $url;
    public $currentTry;

    public function execute($queue)
    {
        $request = curl_init($this->url);
        curl_exec($request);
        $responseHttpCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
        curl_close($request);

        $check = new Checks();

        $check->date_check = new Expression('NOW()');
        $check->url_id = $this->urlId;
        $check->http_code = $responseHttpCode;
        $check->count_try = $this->currentTry;

        $check->save();

        if ($responseHttpCode < 400 || $this->currentTry > $this->repeats) {

            \Yii::$app->queue->delay($this->frequency * 60)->push(
                new CheckJob([
                    'urlId' => $this->urlId,
                    'frequency' => $this->frequency,
                    'repeats' => $this->repeats,
                    'url' => $this->url,
                    'currentTry' => 1
                ])
            );



            return;
        }


        Yii::$app->queue->delay(60)->push(
            new CheckJob([
                'urlId' => $check->id,
                'frequency' => $this->frequency,
                'repeats' => $this->repeats,
                'url' => $this->url,
                'currentTry' => $this->currentTry + 1
            ])
        );
    }


}