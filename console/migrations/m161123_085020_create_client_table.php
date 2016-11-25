<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%order_client}}`.
     */
    class m161125_114959_create_client_table extends Migration{
        protected $tableName = '{{%order_client}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id'            => $this->primaryKey(),
                'user_id'       => $this->integer()
                                        ->notNull(),
                'name'          => $this->string()
                                        ->notNull(),
                'phones'        => $this->string(),
                'birthday'      => $this->integer(),
                'delivery_data' => $this->text(),
                'created_at'    => $this->integer(),
                'updated_at'    => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_Client_TO_User', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_Client_TO_User', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
