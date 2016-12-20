<?php

    namespace backend\models\forms;

    use common\models\CartModel;
    use common\models\ClientModel;
    use common\models\forms\DeliveryAddressForm;
    use common\models\OrderClientDataModel;
    use common\models\OrderDataModel;
    use common\models\OrderModel;
    use common\models\UserIdentity;
    use Yii;
    use yii\base\Model;

    /**
     * Class OrderForm
     * @package backend\models\forms
     *
     * @property OrderModel           $order
     * @property CartModel[]          $carts
     * @property DeliveryAddressForm  $deliveryData
     * @property OrderClientDataModel $client
     */
    class OrderForm extends Model{
        public $order;
        public $orderData;
        public $client;
        public $carts;
        public $payment_id;
        public $delivery_id;
        public $deliveryData;

        public function init(){
            parent::init();

            if($this->order->isNewRecord){
                $this->orderData = [];
                foreach($this->carts as $cart){
                    $order_data = new OrderDataModel();
                    $order_data->product_id = $cart->product_id;
                    $order_data->price = $cart->price;
                    $order_data->quantity = $cart->quantity;
                    $order_data->options = $cart->options;
                    $this->orderData[] = $order_data;
                }
                $this->client = OrderClientDataModel::findAll(['order_id' => $this->order->id]);
            }else{
                $this->orderData = $this->order->orderDatas;
            }
            $this->client = new OrderClientDataModel();
            $del_data = json_decode($this->order->delivery_data);
            $this->deliveryData = new DeliveryAddressForm($del_data ? $del_data : null);
            $this->deliveryData->f_name = $this->client->client->f_name;
            $this->deliveryData->l_name = $this->client->client->l_name;
            $this->deliveryData->email = $this->client->client->email;
        }

        public function loadAll($post){
            if($this->order->load($post) && $this->deliveryData->load($post) && $this->client->load(Yii::$app->request->post(),
                                                                                                    $this->deliveryData->formName())
            ){
                return true;
            }

            return false;
        }

        /**
         * @return bool
         */
        public function save(){
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $this->order->delivery_data = json_encode($this->deliveryData);

                if(!$this->order->save()){
                    throw new \Exception('error save order '.$this->order->getErrors()[0]);
                }

                $this->client->order_id = $this->order->id;
                if(!$this->client->save()){
                    throw new \Exception('error save client data '.$this->client->getErrors()[0]);
                }

                foreach($this->orderData as $od){
                    /** @var OrderDataModel $od */
                    $od->order_id = $this->order->id;
                }
                if(Model::loadMultiple($this->orderData, Yii::$app->request->post())){
                    foreach($this->orderData as $od){
                        if(!$od->save()){
                            throw new \Exception('error save order data '.$od->getErrors()[0]);
                        }
                    }
                }

                $transaction->commit();
                foreach($this->carts as $cart){
                    $cart->delete();
                }

                return true;
            }catch(\Exception $e){
                $transaction->rollBack();

                return false;
            }
        }
    }