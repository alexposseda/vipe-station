<?php

    namespace frontend\controllers;

    use common\models\search\ProductSearchModel;
    use Yii;
    use yii\web\Controller;

    class ShopController extends Controller{

        public function actionCatalog(){
            $catalogSearch = new ProductSearchModel();
            $catalog = $catalogSearch->search(Yii::$app->request->queryParams);

            return $this->render('catalog', ['catalog' => $catalog]);
        }

    }