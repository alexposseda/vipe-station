<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%order_data}}`.
     */
    class m161125_112640_create_order_data_table extends Migration{
        protected $tableName = '{{%order_data}}';

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
                'order_id'   => $this->integer()
                                     ->notNull(),
                'product_id' => $this->integer()
                                     ->notNull(),
                'price'      => $this->float()
                                     ->notNull(),
                'quantity'   => $this->integer()
                                     ->notNull(),
                'options'    => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_OrderData_TO_Order', $this->tableName, 'order_id', '{{%order}}', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('FK_OrderData_TO_Product', $this->tableName, 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_OrderData_TO_Order', $this->tableName);
            $this->dropForeignKey('FK_OrderData_TO_Product', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
