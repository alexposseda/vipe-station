<?php

    namespace common\models\search;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\ProductModel;

    /**
     * ProductSearchModel represents the model behind the search form of `common\models\ProductModel`.
     */
    class ProductSearchModel extends ProductModel{
        public $category_id;
        public $catName;
        public $brand_id;
        public $brandName;
        public $price;

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'id',
                        'category_id',
                        'base_quantity',
                        'sales',
                        'views',
                        'created_at',
                        'updated_at',
                        'brand_id'
                    ],
                    'integer'
                ],
                [
                    [
                        'title',
                        'price',
                        'brandName',
                        'catName',
                        'gallery',
                        'description',
                        'slug'
                    ],
                    'safe'
                ],
                [
                    ['base_price'],
                    'number'
                ],
            ];
        }

        /**
         * @inheritdoc
         */
        public function scenarios(){
            // bypass scenarios() implementation in the parent class
            return Model::scenarios();
        }

        /**
         * Creates data provider instance with search query applied
         *
         * @param array $params
         *
         * @return ActiveDataProvider
         */
        public function search($params){
            $query = ProductModel::find();

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                                                       'query'      => $query,
                                                       'pagination' => [
                                                           'pageSize' => isset($params['pageSize']) ? $params['pageSize'] : 10,
                                                       ],
                                                       'sort'       => [
                                                           'attributes' => [
                                                               'created_at' => ['label' => Yii::t('models/product', 'Novelty')],
                                                               'sales'      => ['label' => Yii::t('models/product', 'Popularity')],
//                                                               'stock'      => ['label' => Yii::t('models/product', 'Discounts')],
                                                               'base_price' => ['label' => Yii::t('models/product', 'Price')],
                                                           ]
                                                       ]

                                                   ]);

            $this->load($params);

            if(!$this->validate()){
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                                       'id'            => $this->id,
                                       'base_quantity' => $this->base_quantity,
                                       'created_at'    => $this->created_at,
                                       'brand_id'      => $this->brand_id,
                                   ]);

            $query->andFilterWhere(['title' => $this->title]);
            if($this->brandName){
                $query->joinWith('brand b')
                      ->andFilterWhere(['b.title' => $this->brandName]);
            }
            if($this->catName){
                $query->joinWith('categories c')
                      ->andFilterWhere(['c.title' => $this->catName]);
            }
            if($this->price){
                $price = explode(';', $this->price);
                $query->andFilterWhere([
                                           'between',
                                           'base_price',
                                           $price[0],
                                           $price[1]
                                       ]);
            }
            if($this->category_id){
                $query->joinWith('categories c')
                      ->andFilterWhere(['c.id' => $this->category_id]);
            }

            $query->andFilterWhere([
                                       'like',
                                       'title',
                                       $this->title
                                   ])
                  ->andFilterWhere([
                                       'like',
                                       'description',
                                       $this->description
                                   ]);

            return $dataProvider;
        }
    }
