<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%order_client_data}}`.
     */
    class m161125_114107_create_order_client_data_table extends Migration{
        protected $tableName = '{{%order_client_data}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id'         => $this->primaryKey(),
                'client_id'  => $this->integer(),
                'order_id'   => $this->integer()->notNull(),
                'name'       => $this->string()->notNull(),
                'email'      => $this->string(),
                'phone'      => $this->string()->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_OrderClientData_TO_Order', $this->tableName, 'order_id', '{{%order}}', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('FK_OrderClientData_TO_Client', $this->tableName, 'client_id', '{{%client}}', 'id', 'SET NULL', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_OrderClientData_TO_Order', $this->tableName);
            $this->dropForeignKey('FK_OrderClientData_TO_Client', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
