<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%related_products}}`.
     */
    class m170103_105045_create_related_products_table extends Migration{
        protected $tableName = '{{%related_products}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'base_product' => $this->integer(),
                'related_product' => $this->integer(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_RELATED_PRODUCT_TO_PRODUCT_1', '{{%related_products}}', 'base_product', '{{%product}}', 'id', 'CASCADE');
            $this->addForeignKey('FK_RELATED_PRODUCT_TO_PRODUCT_2', '{{%related_products}}', 'related_product', '{{%product}}', 'id', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_RELATED_PRODUCT_TO_PRODUCT_1', '{{%related_products}}');
            $this->dropForeignKey('FK_RELATED_PRODUCT_TO_PRODUCT_2', '{{%related_products}}');
            $this->dropTable($this->tableName);
        }
    }
