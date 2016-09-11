<?php

namespace app\controllers;

use Yii;
use app\models\OrderItem;
use app\models\Type;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\Response;
use yii\web\Controller;
use yii\web\ServerErrorHttpException;

/**
 * Controller for ajax-requests of orders
 */
class AjaxOrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['load-types', 'create-item'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Load product types
     * @param $id
     * @return array
     * @throws ForbiddenHttpException
     */
    public function actionLoadTypes($id)
    {
        $request = Yii::$app->getRequest();

        if ($request->isAjax && $request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Type::getList($id);
        } else {
            throw new ForbiddenHttpException();
        }
    }

    /**
     * Creates a new order items
     * @return OrderItem
     * @throws ForbiddenHttpException|ServerErrorHttpException
     */
    public function actionCreateItem()
    {
        $request = Yii::$app->getRequest();

        if ($request->isAjax && $request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $model = OrderItem::findOne([
                'order_id' => $request->post('OrderItem')['order_id'],
                'product_id' => $request->post('OrderItem')['product_id'],
                'type_id' => $request->post('OrderItem')['type_id']
            ]);

            if ($model == null)
                $model = new OrderItem();

            if ($model->load($request->post()) && $model->save()) {
                return $model;
            } else {
                throw new ServerErrorHttpException();
            }
        } else {
            throw new ForbiddenHttpException();
        }
    }
}
