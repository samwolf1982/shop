<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OrderItem */
/* @var $form yii\widgets\ActiveForm */
/* @var $products array */
?>

<div class="order-item-form">

    <?php $form = ActiveForm::begin(['id' => 'order-item-form']); ?>

    <?= Html::activeHiddenInput($model, 'order_id') ?>

    <?= $form->field($model, 'product_id')->dropDownList($products, ['prompt' => '- Выберите продукт -']) ?>

    <?= $form->field($model, 'type_id')->dropDownList([], ['prompt' => '- Выберите тип -', 'disabled' => 'disabled']) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить продукт', ['class' => 'btn btn-success']) ?>
        <span id="loading">Подождите...</span>
    </div>

    <?php ActiveForm::end(); ?>

</div>
