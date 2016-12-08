<?php

    namespace common\models\search;

    use common\models\UserIdentity;
    use PDO;
    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\User;
    use yii\data\Sort;

    /**
     * UserSearch represents the model behind the search form of `common\models\User`.
     */
    class UserSearch extends UserIdentity{
        public $role;

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [
                    [
                        'email',
                        'role'
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
            $query = UserIdentity::find();

            // add conditions that should always apply here

            $dataProvider = new ActiveDataProvider([
                                                       'query' => $query,
                                                       'sort'  => new Sort([
                                                                               'attributes' => [
                                                                                   'id',
                                                                                   'email',
                                                                               ]
                                                                           ])
                                                   ]);

            $this->load($params);

            if(!$this->validate()){
                // uncomment the following line if you do not want to return any records when validation fails
                // $query->where('0 = 1');
                return $dataProvider;
            }

            // grid filtering conditions
            $query->andFilterWhere([
                                       'id'    => $this->id,
                                       'email' => $this->email
                                   ]);

            $query->andFilterWhere(['like', 'email', $this->email]);
            if(!empty($this->role)){
                $ids = (Yii::$app->db->createCommand('SELECT `user_id` FROM {{%auth_assignment}} WHERE `item_name` LIKE \'%'.$this->role."%'")
                                     ->queryAll(PDO::FETCH_COLUMN, 1));
                if(empty($ids)){
                    $query->where('0=1');
                }
                $query->andFilterWhere(['in', 'id', $ids]);
            }

            return $dataProvider;
        }
    }
