<?php

namespace backend\controllers;

use common\models\CartModel;
use common\models\forms\OrderForm;
use common\models\OrderModel;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ConflictHttpException;
use yii\web\Controller;
use yii\web\UnauthorizedHttpException;

class OrderController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors(){
        return [
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete'      => ['POST'],
                ],
            ],
            'access' => [
                'class'        => AccessControl::className(),
                'denyCallback' => function($rule, $action){
                    throw new UnauthorizedHttpException(Yii::t('system/error', 'You do not have access to this page'));
                },
                'rules'        => [
                    [
                        'allow' => true,
                        'roles' => ['admin','manager']
                    ]
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        $orders = new ActiveDataProvider(['query' => OrderModel::find()]);

        return $this->render('index', ['orders' => $orders]);
    }

    public function actionCreate()
    {
        $carts = CartModel::getCart();
        if (empty($carts)) {
            throw new ConflictHttpException(Yii::t('models/order', 'Cart is empty'));
        }
        $order = new OrderForm([
            'carts' => CartModel::getCart(),
            'order' => new OrderModel()
        ]);

        if ($order->loadAll(Yii::$app->request->post()) && $order->save()) {
            Yii::$app->session->addFlash('success', 'Заказ №' . $order->order->id . ' оформлен');

            return $this->redirect(['index']);
        }

        return $this->render('create', ['order' => $order]);
    }

    public function actionUpdate($id)
    {
        $order = new OrderForm([
            'order' => OrderModel::findOne($id)
        ]);
        if ($order->loadAll(Yii::$app->request->post()) && $order->save()) {
            Yii::$app->session->addFlash('success', 'Заказ №' . $order->order->id . ' изменен');

            return $this->redirect(['index']);
        }

        return $this->render('update', ['order' => $order]);
    }

    public function actionDelete($id)
    {
        OrderModel::findOne($id)
            ->delete();
        Yii::$app->cache->flush();
        return $this->redirect(['index']);
    }
}