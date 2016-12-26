<?php

    namespace backend\controllers;

    use backend\models\DeliverPayModel;
    use backend\models\forms\AboutUsForm;
    use backend\models\forms\AddressSettingModel;
    use backend\models\forms\BannerForm;
    use backend\models\forms\ShopSettingForm;
    use backend\models\forms\SocialItemForm;
    use backend\models\forms\SocialModel;
    use backend\models\UploadCover;
    use common\models\ShopSettingTable;
    use Yii;
    use yii\alexposseda\fileManager\actions\RemoveAction;
    use yii\alexposseda\fileManager\actions\UploadAction;
    use yii\alexposseda\fileManager\FileManager;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\UnauthorizedHttpException;

    class SettingShopController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'access' => [
                    'class'        => AccessControl::className(),
                    'denyCallback' => function($rule, $action){
                        throw new UnauthorizedHttpException(Yii::t('system/error', 'You do not have access to this page'));
                    },
                    'rules'        => [
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
         *
         * @return string
         */
        public function actionIndex(){
            $shopSettingModel = new ShopSettingForm();
            $socialSettingModel = new SocialModel();
            $bannerModel = new BannerForm();
            $aboutUsModel = new AboutUsForm();

            if(empty($socialSettingModel->socialForms)){
                $socialSettingModel->socialForms[] = new SocialItemForm();
            }

            if(Yii::$app->request->isPost){
                $formName = Yii::$app->request->post('form');
                $model = null;
                switch($formName){
                    case 'shopSetting':
                        $model = $shopSettingModel;
                        break;

                    case 'socialSetting':
                        $model = $socialSettingModel;
                        break;
                    case 'bannerSetting':
                        $model = $bannerModel;
                        break;
                    case 'aboutSetting':
                        $model = $aboutUsModel;
                        break;
                }
                if(!is_null($model)){
                    if($model->load(Yii::$app->request->post()) && $model->validate()){
                        $model->save();
                    }
                }
            }

            return $this->render('index', [
                'shopSettingModel'   => $shopSettingModel,
                'socialSettingModel' => $socialSettingModel,
                'bannerModel'        => $bannerModel,
                'aboutUsModel'        => $aboutUsModel,
            ]);
        }

        public function actionDeleteSocial($index){
            $model = ShopSettingTable::getSetting('social');
            $socials = json_decode($model->value);
            if(!empty($socials[$index])){
                $social = $socials[$index];
                unset($socials[$index]);
                $socials = array_values($socials);
                $s_icon = $social->icon;
                if(!empty($s_icon)){
                    FileManager::getInstance()->removeFile($s_icon);
                }

                $model->value = json_encode($socials);
                $model->save(false);
            }
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

            if($model->load(Yii::$app->request->post()) ){
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Данные успешно обновлены!');
                }else{
                    Yii::$app->session->setFlash('error', 'Ошибка сохранения данных...');
                }

            }

            return $this->render('address-setting', ['model' => $model]);
        }


    }