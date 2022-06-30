<?php

/** @var yii\web\View $this */

use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use app\models\Checks;
use app\models\Urls;

$this->title = 'Сервис проверки доступности url';
?>

<div>
    <?php
    echo "<h2>URL адреса для проверки доступности</h2>";
    $dataProvider = new ActiveDataProvider([
        'query' => Urls::find(),
        'pagination' => [
            'pageSize' => 4,
        ],
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
                [
                    'attribute' =>'date_created',
                    'label' => 'Дата создания'
                ],
                'url',
                [
                    'attribute' =>'frequency',
                    'label' => 'Частота проверки'
                ],
                [
                    'attribute' =>'repeats',
                    'label' => 'Количество повторов'
                ]
        ]
    ]);
    echo "<h2>Проверки</h2>";
    $dataProvider = new ActiveDataProvider([
        'query' => Checks::find()->with('url'),
        'pagination' => [
            'pageSize' => 4,
        ],
    ]);

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'attribute' =>'date_check',
                'label' => 'Дата проверки'
            ],
            [
                'attribute' =>'url_id',
                'label' => 'url',
                'value' => 'url.url'
            ],
            [
                'attribute' =>'http_code',
                'label' => 'http-код'
            ],
            [
                'attribute' =>'count_try',
                'label' => 'Номер попытки'
            ]
        ]
    ]);
    ?>
</div>
