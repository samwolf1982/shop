<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order_item".
 *
 * @property integer $id
 * @property string $order_id
 * @property integer $product_id
 * @property integer $type_id
 * @property integer $quantity
 *
 * @property Order $order
 * @property Product $product
 */
class OrderItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'required', 'message' => 'Заполните поле'],
            [['quantity'], 'integer', 'message' => 'Значение должно быть числовым'],
            [['order_id', 'type_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product' => 'Продукт',
            'product_id' => 'Продукт',
            'type' => 'Тип',
            'type_id' => 'Тип',
            'quantity' => 'Количество',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return ($this->product != null) ? $this->product->name : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Type::className(), ['id' => 'type_id']);
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return $this->getType()->one()->attributes['name'];
    }
}
