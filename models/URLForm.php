<?php
namespace app\models;

use yii\base\Model;

class URLForm extends Model
{
    public $url;
    public $frequency;
    public $repeats;

    public function rules()
    {
        return [
          [['url', 'frequency', 'repeats'], 'required'],
            ['url', 'unique', 'targetClass' => 'app\models\Urls'],
          ['url', 'url'],
          ['frequency', 'in', 'range' => [1,5,10]],
          ['repeats', 'integer', "min" => 0, "max" => 10]
        ];
    }
}