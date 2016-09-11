<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список заказов';
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать заказ', ['view', 'id' => uniqid()], ['class' => 'btn btn-success']) ?>
    </p>

    <?php \yii\widgets\Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => "{begin}-{end} из {totalCount}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            'product_number',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    /** @var \app\models\Order $model */
                    return date("d.m.Y H:i:s",  $model->created_at);
                },
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy'
                ]),
                'format' => 'html',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view}  {delete}',
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>

</div>
