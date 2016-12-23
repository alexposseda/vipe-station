<?php
    namespace backend\controllers;

    use common\models\forms\PasswordResetRequestForm;
    use common\models\forms\ResetPasswordForm;
    use common\models\forms\SignupForm;
    use common\models\LogModel;
    use common\models\search\LogSearch;
    use Yii;
    use yii\base\InvalidParamException;
    use yii\web\BadRequestHttpException;
    use yii\web\Controller;
    use yii\filters\VerbFilter;
    use yii\filters\AccessControl;
    use common\models\forms\LoginForm;
    use yii\web\NotFoundHttpException;
    use yii\web\UnauthorizedHttpException;

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
                    'class'        => AccessControl::className(),
                    'denyCallback' => function($rule, $action){
                        throw new UnauthorizedHttpException(Yii::t('system/error', 'You do not have access to this page'));
                    },
                    'rules'        => [
                        [
                            'actions' => [
                                'login',
                                'signup',
                                'request-password-reset',
                                'reset-password',
                                'error'
                            ],
                            'allow'   => true,
                        ],
                        [
                            'actions' => [
                                'logout',
                                'index'
                            ],
                            'allow'   => true,
                            'roles'   => ['@'],
                        ],
                        [
                            'actions' => ['index-log'],
                            'allow'   => true,
                            'roles'   => ['admin']
                        ]
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
         * @return string
         */
        public function actionIndex(){
            return $this->render('index');
        }

        /**
         * Login action.
         *
         * @return string
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
         * Logout action.
         *
         * @return string
         */
        public function actionLogout(){
            if(Yii::$app->request->getCookies()
                                 ->has('guest_id')
            ){
                Yii::$app->request->getCookies()
                                  ->remove('guest_id');
            }
            if(Yii::$app->session->has('guest_id')){
                Yii::$app->session->remove('guest_id');
            }
            Yii::$app->user->logout();

            return $this->goHome();
        }

        /**
         * Signs user up.
         *
         * @return mixed
         */
        public function actionSignup(){
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

        public function actionIndexLog(){
            $searchModel = new LogSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index-log', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        public function actionDelete($id){

            $this->findModel($id)
                 ->delete();

            return $this->redirect(['index']);
        }

        protected function findModel($id){
            if(($model = LogModel::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException(Yii::t('system/error', 'The requested page does not exist.'));
            }
        }


    }
