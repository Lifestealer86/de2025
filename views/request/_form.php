<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Request $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin();
    $services = \app\models\Service::find()
        ->select(['name'])
        ->indexBy('id')
        ->column();
    ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_phone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+7(999)-999-99-99', 'options' => ['value' => Yii::$app->user->identity->phone]
    ]) ?>

    <?= $form->field($model, 'desired_datetime')->input('datetime-local') ?>

    <?= $form->field($model, 'service_id')->dropDownList($services) ?>

    <?= $form->field($model, 'other_request')->checkbox() ?>

    <?= $form->field($model, 'custom_service_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_method')->
    dropDownList(['cash' => 'наличные', 'card' => 'банковская карта']) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
