<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "type".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ProductType[] $productTypes
 * @property Product[] $products
 */
class Type extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @param int $productId
     * @return array
     */
    public static function getList($productId)
    {
        $typeData = self::find()
            ->leftJoin(ProductType::tableName(), 'product_type.type_id = type.id')
            ->where('product_type.product_id = :id', [':id' => $productId])
            ->asArray()
            ->all();

        return ArrayHelper::map($typeData, 'id', 'name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductTypes()
    {
        return $this->hasMany(ProductType::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])->viaTable('product_type', ['type_id' => 'id']);
    }
}
