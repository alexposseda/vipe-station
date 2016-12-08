<?php

    namespace common\models\search;

    use Yii;
    use yii\base\Model;
    use yii\data\ActiveDataProvider;
    use common\models\ClientModel;
    use yii\data\Sort;

    /**
     * ClientSearchModel represents the model behind the search form of `common\models\ClientModel`.
     */
    class ClientSearchModel extends ClientModel{
        public $email;

        /**
         * @inheritdoc
         */
        public function rules(){
            return [
                [['name', 'phones', 'email'], 'safe'],
            ];
        }

        public function attributeLabels(){
            return [
                'name'   => Yii::t('models/client', 'Name'),
                'phones' => Yii::t('models/client', 'Phone'),
                'email'  => Yii::t('models/client', 'Email')
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
            $query = ClientModel::find()->joinWith('user');

            $dataProvider = new ActiveDataProvider([
                                                       'query' => $query,
                                                       'sort'  => new Sort([
                                                                               'attributes' => [
                                                                                   'id',
                                                                                   'name',
                                                                                   'birthday',
                                                                                   'email'
                                                                               ]
                                                                           ])
                                                   ]);

            $this->load($params);

            if(!$this->validate()){
                return $dataProvider;
            }

            $query->andFilterWhere(['like', 'email', $this->email]);

            $query->andFilterWhere(['like', 'name', $this->name])
                  ->andFilterWhere(['like', 'phones', $this->phones]);

            return $dataProvider;
        }
    }
