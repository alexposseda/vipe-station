<?php

    namespace common\models\search;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\User;
    use yii\data\Sort;

    /**
     * UserSearch represents the model behind the search form of `common\models\User`.
     */
    class UserSearch extends User{
        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'id',
                        'status',
                        'created_at',
                        'updated_at'
                    ],
                    'integer'
                ],
                [
                    [
                        'auth_key',
                        'password_hash',
                        'password_reset_token',
                        'email'
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
            $query = User::find();

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                                                       'query' => $query,
                                                       'sort'  => new Sort([
                                                                               'attributes' => [
                                                                                   'id',
                                                                                   'email'
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
                                       'id'    => $this->id,
                                       'email' => $this->email
                                   ]);

            $query->andFilterWhere([
                                       'like',
                                       'id',
                                       $this->id
                                   ])
                  ->andFilterWhere([
                                       'like',
                                       'email',
                                       $this->email
                                   ]);

            return $dataProvider;
        }
    }
