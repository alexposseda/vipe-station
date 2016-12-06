<?php

    namespace common\models\search;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\CategoryModel;
    use yii\data\Sort;

    /**
     * CategorySearchModel represents the model behind the search form of `common\models\CategoryModel`.
     */
    class CategorySearchModel extends CategoryModel{
        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'id',
                    ],
                    'integer'
                ],
                [
                    [
                        'title',
                    ],
                    'safe'
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
            $query = CategoryModel::find();

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                                                       'query' => $query,
                                                       'sort'  => new Sort([
                                                                               'attributes' => [
                                                                                   'id',
                                                                                   'title',
                                                                                   'updated_at'
                                                                               ]
                                                                           ])
                                                   ]);

            $this->load($params);

            if(!$this->validate()){
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0=1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                                       'id' => $this->id,
                                   ]);

            $query->andFilterWhere([
                                       'like',
                                       'title',
                                       $this->title
                                   ]);

            return $dataProvider;
        }
    }
