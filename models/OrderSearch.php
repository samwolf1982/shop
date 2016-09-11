<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * OrderSearch represents the model behind the search form about `app\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'product_number'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Order::find()
            ->select('"order".*, "user".username, SUM("order_item".quantity) as product_number')
            ->leftJoin(OrderItem::tableName(), '"order".id = "order_item".order_id')
            ->leftJoin(ShopUser::tableName(), '"order".user_id = "user".id')
            ->where(['user_id' => Yii::$app->user->identity->id])
            ->groupBy('"order".id, "user".username');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_ASC],
                'attributes' => ['id', 'username', 'product_number', 'created_at']
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->product_number)) {
            $query->having(['=', 'SUM("order_item".quantity)', $this->product_number]);
        }

        $query->andFilterWhere(['to_char(to_timestamp(created_at), \'DD.MM.YYYY\')' => $this->created_at]);

        return $dataProvider;
    }
}
