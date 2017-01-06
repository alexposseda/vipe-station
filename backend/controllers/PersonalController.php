<?php
/**
 * Created by PhpStorm.
 * User: Sova
 * Date: 04.01.2017
 * Time: 9:55
 */

namespace backend\controllers;


use common\models\forms\OrderForm;
use yii\web\Controller;

class PersonalController extends Controller
{

    public function actionIndex()
    {
        return $this->render('dashboard');
    }

    public function actionCreateOrderByClient($client_id = null)
    {
        $model = new OrderForm();
        return $this->render('create_by_client', ['model' => $model]);
    }
}