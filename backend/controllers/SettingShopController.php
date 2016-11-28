<?php

    namespace backend\controllers;

    use backend\models\MainSettingShopModel;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;

    class SettingShopController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                ],
            ];
        }

        /**
         * Shop setting
         * # Общие настройки
         * - Название магазина
         * - Ссылки на соц сети
         * - О нас
         * - Баннер на главной и текст к картинке
         * @return string
         */
        public function actionIndex(){
            $model = new MainSettingShopModel();

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->goHome();
            }

            return $this->render('index', ['model' => $model]);
        }
    }