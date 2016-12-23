<?php

    namespace common\models;

    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\caching\DbDependency;
    use yii\db\ActiveRecord;
    use yii\web\Cookie;

    /**
     * This is the model class for table "{{%cart}}".
     *
     * @property integer      $id
     * @property integer      $user_id
     * @property string       $guest_id
     * @property integer      $product_id
     * @property string       $options
     * @property integer      $quantity
     * @property integer      $created_at
     * @property integer      $updated_at
     *
     * @property ProductModel $product
     * @property User         $user
     * @property mixed        price
     */
    class CartModel extends ActiveRecord{
        public static function getCart(){
            if(!Yii::$app->user->isGuest){
                $guest_id = Yii::$app->request->cookies->get('guest_id');
                if($guest_id){
                    $guest_id = Yii::$app->session->get('guest_id');
                }
                $condition = ['guest_id' => $guest_id];
            }else{
                $condition = ['user_id' => Yii::$app->user->id];
            }

            return self::findAll($condition);
        }

        public static function findByGuestId($guest_id){
            return self::getDb()
                       ->cache(function() use ($guest_id){
                           return self::findAll(['guest_id' => $guest_id]);
                       }, 0, new DbDependency(['sql' => 'SELECT MAX(`updated_at`) FROM '.self::tableName()]));
        }

        /**
         * @inheritdoc
         */
        public function behaviors(){
            return [
                TimestampBehavior::className(),
            ];
        }

        /**
         * @inheritdoc
         */
        public static function tableName(){
            return '{{%cart}}';
        }

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['user_id', 'product_id', 'quantity', 'created_at', 'updated_at'], 'integer'],
                [['product_id', 'quantity'], 'required'],
                [['guest_id', 'options'], 'string', 'max' => 255],
                [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels(){
            return [
                'id'         => 'ID',
                'user_id'    => 'User ID',
                'guest_id'   => 'Guest ID',
                'product_id' => 'Product ID',
                'options'    => Yii::t('models/cart', 'Options'),
                'quantity'   => Yii::t('models/cart', 'Quantity'),
                'created_at' => Yii::t('models', 'Created'),
                'updated_at' => Yii::t('models', 'Last Update'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getUser(){
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getProduct(){
            return $this->hasOne(ProductModel::className(), ['id' => 'product_id']);
        }

        public function getPrice(){
            $price = $this->product->base_price;
            if($this->options){
                $options = json_decode($this->options);
                if(!empty($options->options)){
                    foreach($options->options as $option){
                        $optionModel = ProductOptionModel::findOne($option);
                        $price += $optionModel->delta_price;
                    }
                }
            }

            return $price * $this->quantity;
        }

        public function setID(){
            if(Yii::$app->user->isGuest){

                $cookie_guestId = Yii::$app->request->cookies->getValue('guest_id');
                $session_guestId = Yii::$app->session->get('guest_id');
                if(empty($cookie_guestId) && empty($session_guestId)){
                    $this->guest_id = Yii::$app->security->generateRandomString();
                    Yii::$app->response->cookies->add(new Cookie([
                                                                     'name'  => 'guest_id',
                                                                     'value' => $this->guest_id
                                                                 ]));
                    Yii::$app->session->set('guest_id', $this->guest_id);
                }else{
                    $this->guest_id = empty($cookie_guestId) ? $session_guestId : $cookie_guestId;
                }
            }else{
                $this->user_id = Yii::$app->user->id;
            }
        }

        public function actionAddToCart($product_id, $options, $quantity){
            $cart = new CartModel();
            if(Yii::$app->user->isGuest){

                $cookie_guestId = Yii::$app->request->getCookies()
                                                    ->getValue('guest_id');
                $session_guestId = Yii::$app->session->get('guest_id');
                $cart->guest_id = Yii::$app->security->generateRandomString();
                if(empty($cookie_guestId && $session_guestId)){
                    Yii::$app->response->cookies->add(new Cookie([
                                                                     'name'  => 'guest_id',
                                                                     'value' => $cart->guest_id
                                                                 ]));
                    Yii::$app->session->set('guest_id', $cart->guest_id);
                }else{
                    empty($cookie_guestId) ? $cart->guest_id = $session_guestId : $cart->guest_id = $cookie_guestId;
                }
            }else{
                $cart->user_id = Yii::$app->user->id;
            }
            $cart->product_id = $product_id;
            $cart->options = $options;
            $cart->quantity = $quantity;
            if($cart->save()){
                return true;
            }
            Yii::$app->session->setFlash('error', 'Error save cart');
            return false;
        }

    }
