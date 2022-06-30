<?php

/** @var yii\web\View $this */
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Сервис проверки доступности url';
?>
<div>
<?php $form = ActiveForm::begin() ?>
    <?= $form->field($model,'url')->label('URL адрес') ?>
    <?= $form->field($model, 'frequency')->label('Частота проверки')->radioList([1 => '1 минута', 5 => '5 минут', 10 => '10 минут']) ?>
    <?= $form->field($model, 'repeats')->label('Количество повторов в случае ошибки')->textInput(['type' => 'number', 'min' => 0, 'max' => 10]) ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end() ?>
</div>
