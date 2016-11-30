<?php

    namespace backend\controllers;

    use backend\models\AddressSettingModel;
    use backend\models\DeliverPayModel;
    use backend\models\MainSettingShopModel;
    use backend\models\UploadCover;
    use Yii;
    use yii\alexposseda\fileManager\actions\RemoveAction;
    use yii\alexposseda\fileManager\actions\UploadAction;
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

        public function actions(){
            return [
                'del-logo-upload' => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'deliver',
                    'sessionEnable' => true,
                    'uploadModel'   => new UploadCover([
                                                           'validationRules' => [
                                                               'extensions' => 'jpg, png',
                                                               'maxSize'    => 1024 * 500
                                                           ]
                                                       ])
                ],
                'del-logo-remove' => ['class' => RemoveAction::className()],
                'pay-logo-upload' => [
                    'class'         => UploadAction::className(),
                    'uploadPath'    => 'payment',
                    'sessionEnable' => true,
                    'uploadModel'   => new UploadCover([
                                                           'validationRules' => [
                                                               'extensions' => 'jpg, png',
                                                               'maxSize'    => 1024 * 500
                                                           ]
                                                       ])
                ],
                'pay-logo-remove' => ['class' => RemoveAction::className()],
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

        public function actionDeliverPay(){
            $model = new DeliverPayModel();

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->goHome();
            }

            return $this->render('delivery-payment', ['model' => $model]);
        }

        public function actionAddressSetting(){
            $model = new AddressSettingModel();

            if($model->load(Yii::$app->request->post()) && $model->save()){
                return $this->goHome();
            }
            return $this->render('address-setting',['model'=>$model]);
        }


    }