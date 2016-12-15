<?php

    namespace backend\models\forms;

    use common\models\ProductInStockModel;
    use common\models\ProductModel;
    use common\models\StockModel;
    use Yii;
    use yii\base\Model;
    use yii\caching\DbDependency;
    use yii\helpers\ArrayHelper;

    /**
     * Class StockForm
     *
     * @package backend\models\forms
     *
     * @property StockModel stock
     */
    class StockForm extends Model{
        public $stock;
        public $products;
        public $categories;

        public function rules(){
            return [
                [['products', 'categories'], 'safe']
            ];
        }

        public function loadData($data, $formName = null){
            if($this->load($data)){
                if($this->stock->load($data)){
                    return true;
                }
            }

            return false;
        }

        public function save(){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                if(!$this->stock->save()){
                    throw new \Exception('error save stock');
                }
                if(!empty($this->products)){
                    foreach($this->products as $product_id){
                        $prod_in_stock = $this->stock->getProductInStocks()
                                                     ->where(['product_id' => $product_id])
                                                     ->one();
                        if($prod_in_stock){
                            continue;
                        }
                        $prod_in_stock = new ProductInStockModel([
                                                                     'stock_id'   => $this->stock->id,
                                                                     'product_id' => $product_id
                                                                 ]);
                        if(!$prod_in_stock->save()){
                            throw new \Exception('error save product in stock');
                        }
                    }
                }else{
                    $all_in_stock = $this->stock->productInStocks;
                    if(!empty($all_in_stock)){
                        foreach($all_in_stock as $item){
                            $item->delete();
                        }
                        Yii::$app->cache->flush();
                    }
                }

                $diff_prod_in_stock = $this->stock->getProductInStocks()
                                                  ->where(['not in', 'product_id', $this->products])
                                                  ->all();
                if(!empty($diff_prod_in_stock)){
                    foreach($diff_prod_in_stock as $item){
                        $item->delete();
                    }
                    Yii::$app->cache->flush();
                }

                $transaction->commit();

                return true;
            }catch(\Exception $e){
                $transaction->rollBack();

                return false;
            }
        }

        public function getAllProducts(){
            $p_in_stock = ProductInStockModel::getDb()
                                             ->cache(function(){
                                                 return ProductInStockModel::find()
                                                                           ->all();
                                             }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.ProductInStockModel::tableName()]));

            $prod_all = ProductModel::getDb()
                                    ->cache(function() use ($p_in_stock){
                                        return ProductModel::find()
                                                           ->where([
                                                                       'not in',
                                                                       'id',
                                                                       ArrayHelper::getColumn($p_in_stock, 'product_id')
                                                                   ])
                                                           ->all();
                                    });

            return ArrayHelper::merge(ArrayHelper::map($prod_all, 'id', 'title'), ArrayHelper::map($this->stock->products, 'id', 'title'));
        }
    }