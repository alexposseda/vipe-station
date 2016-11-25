<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%product_in_stock}}`.
     */
    class m161125_135147_create_product_in_stock_table extends Migration{
        protected $tableName = '{{%product_in_stock}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'stock_id' => $this->integer()->notNull(),
                'product_id' => $this->integer()->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addPrimaryKey('PK_ProductInStock', $this->tableName, ['stock_id', 'product_id']);
            $this->addForeignKey('FK_ProductInStock_TO_Stock', $this->tableName, 'stock_id', '{{%stock}}', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('FK_ProductInStock_TO_Product', $this->tableName, 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_ProductInStock_TO_Stock', $this->tableName);
            $this->dropForeignKey('FK_ProductInStock_TO_Product', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
