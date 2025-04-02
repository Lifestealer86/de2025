<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Request $model */

$this->title = 'Ответ на заявку пользователя: ' . Html::encode($model->user->full_name);
// "хлебные крошки" удалены
?>
<div class="request-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formAdmin', [
        'model' => $model,
    ]) ?>

</div>
