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
            $cart = new CartModel();
            $cart->setID();

            $cart->product_id = $this->product_id;

            $cart->options = json_encode(['characteristics' => $this->characteristic_id, 'options' => $this->option_id]);
            $cart->quantity = $this->quantity;
            if($cart->save()){
                return true;
            }

            return false;
        }

        public function characteristics($model){
            return ArrayHelper::map($model->productCharacteristicItems, 'id', 'characteristic.title');
        }

        public function options($model){
            return ArrayHelper::map($model->productOptions, 'id', 'characteristic.title');
        }
    }