<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Request $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="request-form">

    <?php $form = ActiveForm::begin();
    $request = app\models\Request::findOne($model->id);
    ?>

    <h2>Услуга -
        <?php
        $service = app\models\Service::findOne($model->service_id);
        echo $service ? Html::encode($service->name) :
            Html::encode($request->custom_service_description) . " (своя услуга)";
        ?>
        (Телефон: <?= Html::encode($request->contact_phone); ?>)
    </h2>

    <p>Адрес: <?= Html::encode($request->address); ?></p>

    <h3><?= $model->getAttributeLabel('desired_datetime') ?></h3>
    <p><?= Html::encode(date('d-m-Y H:m', strtotime($request->desired_datetime))) ?></p>

    <h3><?= $model->getAttributeLabel('payment_method') ?></h3>
    <p><?= ($request->payment_method == "card") ?  "банковская карта" : "наличные"; ?></p>

    <?= $form->field($model, 'status')->dropDownList([ 'in_progress' => 'В работе',
        'completed' => 'Выполнено', 'cancelled' => 'Отменено' ], ['prompt' => '']) ?>

    <?= $form->field($model, 'cancellation_reason')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Ответить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
