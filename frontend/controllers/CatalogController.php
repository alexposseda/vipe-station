<?php

    namespace frontend\controllers;

    use common\models\ProductCharacteristicItemModel;
    use common\models\ProductCharacteristicModel;
    use common\models\ProductModel;
    use common\models\search\BrandSearchModel;
    use common\models\search\ProductSearchModel;
    use frontend\models\SendMailForm;
    use Yii;
    use yii\db\Query;
    use yii\helpers\Url;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;

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
            $model = ProductModel::findOne(['slug' => $slug]);
            if(!$model){
                throw new NotFoundHttpException();
            }

            return $this->render('product', ['model' => $model, 'url' => Url::current()]);
        }

        public function actionGetProduct(){
            $options = Yii::$app->request->get('options');
            if(empty($options)){
                throw new NotFoundHttpException();
            }
            $query = (new Query())->select(['count(*) as c','product_id'])->from(ProductCharacteristicItemModel::tableName());
            foreach($options as $characteristic_id => $value){
                $query->orWhere(['value' => $value]);
            }
            $query->groupBy('product_id');
            $result = $query->createCommand()->queryAll();
            $target= count($options);
            $model = null;
            foreach($result as $row){
                if($row['c'] == $target){
                    $model = ProductModel::findOne($row['product_id']);
                    break;
                }
            }
            if(!is_null($model)){
                return $this->render('product', ['model' => $model, 'url' => Url::current()]);
            }else{
                return $this->render('productNotFound');
            }
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