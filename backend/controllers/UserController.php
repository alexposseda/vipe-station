<?php

    namespace backend\controllers;

    use common\models\search\UserSearch;
    use common\models\UserIdentity;
    use Yii;
    use common\models\User;
    use yii\data\ActiveDataProvider;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;
    use yii\web\UnauthorizedHttpException;

    /**
     * UserController implements the CRUD actions for User model.
     */
    class UserController extends Controller{
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
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ];
        }

        /**
         * Lists all User models.
         * @return mixed
         */
        public function actionIndex(){
            $searchModel = new UserSearch();
            $dataProvider = new ActiveDataProvider([
                                                       'query' => User::find(),
                                                   ]);

            return $this->render('index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        /**
         * Displays a single User model.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionView($id){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }

        /**
         * Creates a new User model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate(){
            $model = new User();
            $rol_user = 'user';

            if($model->load(Yii::$app->request->post()) && $model->save() && $model->setUserRole(Yii::$app->request->post('role'))){
                return $this->redirect([
                                           'view',
                                           'id' => $model->id
                                       ]);
            }else{
                return $this->render('create', [
                    'model'    => $model,
                    'rol_user' => $rol_user,
                ]);
            }
        }

        /**
         * Updates an existing User model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate($id){
            $model = $this->findModel($id);
            $rol_user = current(Yii::$app->authManager->getRolesByUser($model->id))->name;

            if($model->load(Yii::$app->request->post()) && $model->save() && $model->setUserRole(Yii::$app->request->post('role'))){
                return $this->redirect([
                                           'view',
                                           'id' => $model->id
                                       ]);
            }else{
                return $this->render('update', [
                    'model'    => $model,
                    'rol_user' => $rol_user,
                ]);
            }
        }

        /**
         * Deletes an existing User model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionDelete($id){
            $user_roles = current(Yii::$app->authManager->getRolesByUser($id));
            if($user_roles->name != 'admin'){
                $this->findModel($id)
                     ->delete();
                Yii::$app->authManager->revoke($user_roles, $id);
            }

            return $this->redirect(['index']);
        }

        /**
         * Finds the User model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return User the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id){
            if(($model = User::findOne($id)) !== null){
                return $model;
            }else{
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }
