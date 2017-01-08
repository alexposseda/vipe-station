<?php

    namespace frontend\controllers;

    use common\models\search\BrandSearchModel;
    use common\models\search\ProductSearchModel;
    use frontend\models\SendMailForm;
    use Yii;
    use yii\web\Controller;

    /**
     * Class CatalogController
     * @package frontend\controllers
     *
     */
    class CatalogController extends Controller{

        protected $_search;
        public $layout = 'catalog';

        public function init(){
            parent::init();
            $this->_search = new ProductSearchModel();
        }

        public function actionIndex(){
            $popular = $this->_search->search(Yii::$app->request->queryParams);
            $popular->sort->defaultOrder = ['sales' => SORT_DESC];

            $brands = (new BrandSearchModel())->search(Yii::$app->request->queryParams);
            $brands->sort->defaultOrder = ['title' => SORT_DESC];

            return $this->render('index', ['popular' => $popular, 'brands' => $brands]);
        }

        public function actionBrand($slug = null){
            if(!is_null($slug)){
                $this->_search->brandSlug = $slug;
                $catalog = $this->_search->search(Yii::$app->request->queryParams);
                $catalog->pagination->pageSize = 8;

                return $this->render('catalogAll', ['catalog' => $catalog]);
            }

            $brands = (new BrandSearchModel())->search(Yii::$app->request->queryParams);
            $brands->sort->defaultOrder = ['title' => SORT_DESC];

            return $this->render('brands', ['brands' => $brands]);
        }

        public function actionProduct($slug){
            $this->_search->slug = $slug;
            $catalog = $this->_search->search(Yii::$app->request->queryParams);

            return $this->render('product', ['model' => $catalog->models[0]]);
        }

        public function actionCategory($slug = null){
            $this->_search->catSlug = $slug;
            $catalog = $this->_search->search(Yii::$app->request->queryParams);
            $catalog->pagination->pageSize = 8;

            return $this->render('catalogAll', ['catalog' => $catalog]);
        }

        public function actionSendMail(){
            $model = new SendMailForm();
            if($model->load(Yii::$app->request->post()) && $model->send()){
                //todo сделать оповещение пользователя об успешном заказе
            }

            return $this->goBack(Yii::$app->request->post('submit'));
        }

    }