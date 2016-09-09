<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $created_at
 *
 * @property ShopUser $user
 * @property OrderItem[] $orderItems
 */
class Order extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_number' => 'Количество товаров',
            'user' => 'Пользователь',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => false,
                'value' => time(),
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(ShopUser::className(), ['id' => 'user_id']);
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return ($this->user != null) ? $this->user->username : '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
     * @return int
     */
    public function getProductNumber()
    {
        return $this->getOrderItems()->sum('quantity');
    }
}
