<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%product_in_category}}`.
     */
    class m161123_131959_create_product_in_category_table extends Migration{
        protected $tableName = '{{%product_in_category}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'category_id' => $this->integer(),
                'product_id' =>$this->integer(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addPrimaryKey('PK_ProductInCategory', $this->tableName, ['category_id', 'product_id']);
            $this->addForeignKey('FK_ProductInCategory_TO_Category', $this->tableName, 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('FK_ProductInCategory_TO_Product', $this->tableName, 'product_id', '{{%product}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_ProductInCategory_TO_Category', $this->tableName);
            $this->dropForeignKey('FK_ProductInCategory_TO_Product', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
