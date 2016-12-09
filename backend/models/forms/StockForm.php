<?php

    namespace backend\models\forms;

    use common\models\ProductInStockModel;
    use common\models\ProductModel;
    use common\models\StockModel;
    use Yii;
    use yii\base\Model;
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

        public function init(){
            if($this->stock){
                $this->products = ArrayHelper::map($this->stock->products, 'id', 'title');

            }
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
                }

                $transaction->commit();
            }catch(\Exception $e){
                $transaction->rollBack();
            }
        }

        public function getAllProducts(){
            $all_product = ArrayHelper::map(ProductModel::find()
                                                        ->where([
                                                                    '!=',
                                                                    'id',
                                                                    ProductInStockModel::find()
                                                                                       ->select(['product_id'])
                                                                                       ->asArray()
                                                                ])
                                                        ->all(), 'id', 'title');

            return ArrayHelper::merge($all_product, $this->products);
        }

        public function checked($index, $label, $name, $checked, $value){
            $d =5;
        }


    }