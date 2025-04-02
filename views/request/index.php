<?php

use app\models\Request;
use app\models\Service;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::$app->user->identity->isAdmin() ? 'Заявки' : 'Мои заявки';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin()) {
        echo Html::a('Подать заявку', ['create'], ['class' => 'btn btn-success']);
        echo ListView::widget([
            'dataProvider' => $dataProvider,
            'options' => ['class' => 'row g-4'],
            'itemOptions' => ['class' => 'col-md-4'],
            'itemView' => function ($model, $key) {
                $service_name = Service::findOne($model->service_id)->name
                    ?? $model->custom_service_description." (Своя услуга)";
                $payment = ['cash' => 'Наличные', 'card' => 'Банковская карта'];
                $statuses = ["new" => ["name" => "Новая", "class" => "bg-secondary bg-gradient"],
                    "in_progress" => ["name" => "В работе", "class" => "bg-primary bg-gradient"],
                    "cancelled" => ["name" => "Отменено", "class" => "bg-danger bg-gradient"],
                    "completed" => ["name" => "Выполнено", "class" => "bg-success bg-gradient"]
                ];
                $current_status = $model->status == "cancelled"
                    ? $statuses[$model->status]["name"]. ' (' . $model->cancellation_reason . ')'
                    : $statuses[$model->status]["name"];
                $delete = ($model->status === "new") ? Html::a('&#x2620;', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger p-1 text-white',
                'data-confirm' => 'Вы уверены, что хотите удалить этот элемент?']) : "";
                return '
                <div class="card shadow-sm">
                    <div class="card-header '
                    . $statuses[$model->status]["class"] .
                    ' text-white d-flex justify-content-between">
                        <h5 class="card-title">Заявка № ' . Html::encode($key) . '</h5>
                        '. $delete .'
                    </div>
                    <div class="card-body">
                        <p class="d-flex justify-content-between">
                            <b>Услуга: </b>'
                            . $service_name .
                        '</p>
                        <p class="d-flex justify-content-between">
                            <b>Адрес: </b>'
                            . $model->address .
                        '</p>
                        <p class="d-flex justify-content-between">
                            <b>Телефон: </b>'
                            . $model->contact_phone .
                        '</p>
                        <p class="d-flex justify-content-between">
                            <b>Желательное время: </b>'
                            . date('d-m-Y H:i', strtotime($model->desired_datetime)) .
                        '</p>
                        <p class="d-flex justify-content-between">
                            <b>Способ оплаты: </b>'
                            . $payment[$model->payment_method] .
                        '</p>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <b>Статус: </b>'
                        . $current_status .
                    '</div>
                </div>
            ';
            }
        ]);
    } else if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()) {
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'id',
                'user_id',
                'service_id',
                'address',
                'contact_phone',
                //'desired_datetime',
                //'custom_service_description',
                //'payment_method',
                'status',
                //'cancellation_reason',
                [
                    'class' => ActionColumn::className(),
                    'template' => '{update}',
                    'urlCreator' => function ($action, Request $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'buttons' => [
                        'update' => function ($url) {
                            return Html::a('<span class="btn btn-primary" type="button">Ответить на заявку</span>', $url);
                        },
                    ],
                ],
            ],
        ]);
    } ?>
</div>
