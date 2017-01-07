<?php
    namespace frontend\controllers;

    use common\components\sender\Sender;
    use common\models\BrandModel;
    use common\models\forms\LoginForm;
    use common\models\forms\PasswordResetRequestForm;
    use common\models\forms\ResetPasswordForm;
    use common\models\forms\SignupForm;
    use common\models\search\BrandSearchModel;
    use common\models\ShopSettingTable;
    use frontend\models\AddressForm;
    use Yii;
    use yii\alexposseda\fileManager\FileManager;
    use yii\base\InvalidParamException;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\filters\AccessControl;
    use frontend\models\ContactForm;

    /**
     * Site controller
     */
    class SiteController extends Controller{
        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'only'  => [
                        'logout',
                        'signup'
                    ],
                    'rules' => [
                        [
                            'actions' => ['signup'],
                            'allow'   => true,
                            'roles'   => ['?'],
                        ],
                        [
                            'actions' => ['logout'],
                            'allow'   => true,
                            'roles'   => ['@'],
                        ],
                    ],
                ],
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ];
        }


        /**
         * @inheritdoc
         */
        public function actions(){
            return [
                'error' => [
                    'class' => 'yii\web\ErrorAction',
                ],
            ];
        }

        /**
         * Displays homepage.
         *
         * @return mixed
         */
        public function actionIndex(){
            return $this->render('index');
        }

        public function actionAbout(){
            $aboutUs = ShopSettingTable::getSettingValue('aboutUs');
            if(empty($aboutUs)){
                $aboutUs = Yii::t('system/error', 'Sorry, Information is not available');
            }

            $addressForm = new AddressForm();

            return $this->render('about', [
                'listAddress' => $addressForm->getAllAddress(),
                'aboutUs'     => $aboutUs
            ]);
        }

        public function actionShippingPayment(){

            $delivery = json_decode(ShopSettingTable::getSettingValue('delivery_'.Yii::$app->language));
            $listDelivery = [];
            if(!empty($delivery)){
                $listDelivery['logo'] = $delivery[0]->logo;
                $listDelivery['title'] = $delivery[0]->title;
                $listDelivery['desc'] = $delivery[0]->desc;
            }

            $payment = json_decode(ShopSettingTable::getSettingValue('payment_'.Yii::$app->language));
            $listPayment = [];
            if(!empty($payment)){
                $listPayment['logo'] = $payment[0]->logo;
                $listPayment['title'] = $payment[0]->title;
                $listPayment['desc'] = $payment[0]->desc;
            }

            return $this->render('shipping-payment', [
                'listDelivery' => $listDelivery,
                'listPayment'  => $listPayment
            ]);
        }

        public function actionShops(){
            return $this->render('shops');
        }

        /**
         * Logs in a user.
         *
         * @return mixed
         */
        public function actionLogin(){
            if(!Yii::$app->user->isGuest){
                return $this->goHome();
            }

            $model = new LoginForm();
            if($model->load(Yii::$app->request->post()) && $model->login()){
                return $this->goBack();
            }else{
                return $this->render('login', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Logs out the current user.
         *
         * @return mixed
         */
        public function actionLogout(){
            Yii::$app->user->logout();

            return $this->goHome();
        }

        /**
         * Signs user up.
         *
         * @return mixed
         */
        public function actionSignup(){
            if(!Yii::$app->user->isGuest){
                return $this->goHome();
            }
            $model = new SignupForm();
            if($model->load(Yii::$app->request->post())){
                if($user = $model->signup()){
                    return $this->goHome();
                }
            }

            return $this->render('signup', [
                'model' => $model,
            ]);
        }

        /**
         * Requests password reset.
         *
         * @return mixed
         */
        public function actionRequestPasswordReset(){
            $model = new PasswordResetRequestForm();
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->sendEmail()){
                    Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                    return $this->goHome();
                }else{
                    Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
                }
            }

            return $this->render('requestPasswordResetToken', [
                'model' => $model,
            ]);
        }

        /**
         * Resets password.
         *
         * @param string $token
         *
         * @return mixed
         * @throws BadRequestHttpException
         */
        public function actionResetPassword($token){
            try{
                $model = new ResetPasswordForm($token);
            }catch(InvalidParamException $e){
                throw new BadRequestHttpException($e->getMessage());
            }

            if($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()){
                Yii::$app->session->setFlash('success', 'New password was saved.');

                return $this->goHome();
            }

            return $this->render('resetPassword', [
                'model' => $model,
            ]);
        }


    }
