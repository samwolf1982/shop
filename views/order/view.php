<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use app\assets\OrderAsset;

/* @var $this yii\web\View */
/* @var $orderItem app\models\OrderItem */
/* @var $orderItemProvider yii\data\ActiveDataProvider */
/* @var $products array */

$this->title = 'Заказ';
$this->params['breadcrumbs'][] = ['label' => 'Список заказов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

OrderAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p><b>ID:</b> <?= Html::encode($orderItem->order_id) ?></p>

    <div class="col-md-4 row">
        <?= $this->render('_form', [
            'model' => $orderItem,
            'products' => $products
        ]) ?>
    </div>

    <div class="col-md-12 row">

        <h3>Список продуктов в заказе</h3>

        <?php Pjax::begin(['id' => 'pjax-container']); ?>

        <?= GridView::widget([
            'id' => 'order-datatable',
            'dataProvider' => $orderItemProvider,
            'summary' => "{begin}-{end} из {totalCount}",
            'columns' => [
                [
                    'attribute' => 'product',
                    'value' => function ($model) {
                        return $model->getProductName();
                    }
                ],
                [
                    'attribute' => 'type',
                    'value' => function ($model) {
                        return $model->getTypeName();
                    }
                ],
                [
                    'attribute' => 'quantity',
                    'value' => function ($model) {
                        return $model->quantity;
                    }
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>

        <a href="<?= Url::to('/order/index') ?>">
            <?= Html::button('Список заказов', ['class' => 'btn btn-primary']) ?>
        </a>

    </div>

</div>