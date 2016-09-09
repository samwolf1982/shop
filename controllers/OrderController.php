<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\OrderItem;
use app\models\OrderSearch;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

/**
 * Controller for orders
 */
class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all orders
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single order
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $order = Order::findOne($id);

        if ($order == null) {
            $order = new Order();
            $order->id = $id;
            $order->user_id = Yii::$app->user->identity->id;
            $order->save();
        }

        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItemProvider = new ActiveDataProvider([
            'query' => OrderItem::find()->where(['order_id' => $order->id]),
            'sort' => false
        ]);

        return $this->render('view', [
            'orderItem' => $orderItem,
            'orderItemProvider' => $orderItemProvider,
            'products' => Product::getList()
        ]);
    }

    /**
     * Deletes an existing order
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if (Order::findOne($id)->delete()) {
            return $this->redirect(['index']);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
