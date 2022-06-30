<?php

namespace app\models;

use yii\db\ActiveRecord;

class Checks extends ActiveRecord
{
    public function getUrl()
    {
        return $this->hasOne('app\models\Urls', ['id' => 'url_id']);
    }
}