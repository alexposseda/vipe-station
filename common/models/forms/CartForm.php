<?php

    namespace common\models\forms;

    use common\models\CartModel;
    use Yii;
    use yii\base\Model;
    use yii\helpers\ArrayHelper;

    class CartForm extends Model{
        public $characteristic_id;
        public $option_id;
        public $product_id;
        public $quantity = 1;

        protected $_cartItems = [];

        public function init(){
            $this->_cartItems = CartModel::getCart();
        }

        public function attributeLabels(){
            return [
                'characteristic_id' => Yii::t('models', 'Characteristics'),
                'option_id'         => Yii::t('models', 'Options'),
                'product_id'        => Yii::t('models', 'Product'),
                'quantity'          => Yii::t('models/cart', 'Quantity')
            ];
        }

        public function rules(){
            return [
                [['characteristic_id', 'option_id', 'product_id', 'quantity'], 'integer']
            ];
        }

        public function add(){
            $index = $this->findInCart($this->product_id);
            $model = null;
            if($index !== false){
                $model = $this->_cartItems[$index];
                $model->quantity += $this->quantity;
            }else{
                $model = new CartModel(['product_id' => $this->product_id, 'quantity' => $this->quantity]);
                $this->_cartItems[] = $model;
            }

            return $model->save();
        }

        public function characteristics($model){
            return ArrayHelper::map($model->productCharacteristicItems, 'id', 'characteristic.title');
        }

        public function options($model){
            return ArrayHelper::map($model->productOptions, 'id', 'characteristic.title');
        }

        protected function findInCart($product_id){
            if(!is_null($this->_cartItems)){
                foreach($this->_cartItems as $index => $cartItem){
                    if($cartItem->product_id == $product_id){
                        return $index;
                    }
                }
            }

            return false;
        }
    }
