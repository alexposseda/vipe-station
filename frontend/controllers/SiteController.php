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
    use Yii;
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
                'error'   => [
                    'class' => 'yii\web\ErrorAction',
                ],
                'captcha' => [
                    'class'           => 'yii\captcha\CaptchaAction',
                    'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                ],
            ];
        }

        public function actionTest(){
            $search = new BrandSearchModel();
            $dataProvider = $search->search(Yii::$app->request->queryParams);

            return $this->render('test_cache', ['dataProvider' => $dataProvider]);

            //        $mailer = new Sender();
            //        if(!$mailer->sendMail('alexposseda@gmail.com', 'test sender', 'test')){
            //            echo '<pre>'.$mailer->getErrors()[0].'</pre>';
            //        }else{
            //            var_dump('Success');
            //        }
        }

        /**
         * Displays homepage.
         *
         * @return mixed
         */
        public function actionIndex(){

            $bannerTitle = ShopSettingTable::getSettingValue('bannerTitle');
            if(is_null($bannerTitle))
                $bannerTitle =  'Lorem ipsum dolor sit amet, consectetur adipisicing elit';
            $tmp = strrpos($bannerTitle, ",");
            if($tmp !== false){
                $bannerTitle = substr($bannerTitle, 0, $tmp + 1)."<br> ".substr($bannerTitle, $tmp + 1);
            }

            $bannerFile = ShopSettingTable::getSettingValue('bannerFile');

            return $this->render('index', [
                'bannerTitle' => $bannerTitle,
                'bannerFile'  => $bannerFile
            ]);
        }

        public function actionAbout(){
            $aboutUs = ShopSettingTable::getSettingValue('aboutUs');
            if(is_null($aboutUs))
                $aboutUs = Yii::t('system/error', 'Sorry, Information is not available');
            return $this->render('about',[
                'aboutUs' => $aboutUs
            ]);
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
