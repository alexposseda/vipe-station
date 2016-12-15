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
        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['id', 'base_quantity', 'sales', 'views', 'created_at', 'updated_at', 'brand_id'], 'integer'],
                [['title', 'gallery', 'description', 'slug'], 'safe'],
                [['base_price'], 'number'],
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
                                                           'pageSize' => $params['pageSize'],
                                                       ],
                                                       'sort'       => [
                                                           'attributes' => [
                                                               'sales',
                                                               'base_price',
                                                               'created_at',
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
                                       'base_price'    => $this->base_price,
                                       'base_quantity' => $this->base_quantity,
                                       'sales'         => $this->sales,
                                       'views'         => $this->views,
                                       //            'seo_id' => $this->seo_id,
                                       'created_at'    => $this->created_at,
                                       //            'updated_at' => $this->updated_at,
                                       'brand_id'      => $this->brand_id,
                                   ]);

            $query->andFilterWhere(['like', 'title', $this->title])//            ->andFilterWhere(['like', 'gallery', $this->gallery])
                  ->andFilterWhere(['like', 'description', $this->description]);

            return $dataProvider;
        }
    }
