<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%product_characteristic}}`.
     */
    class m161123_124135_create_product_characteristic_table extends Migration{
        protected $tableName = '{{%product_characteristic}}';

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
                'category_id' => $this->integer()->notNull(),
                'title' => $this->string()->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_ProductCharacteristic_TO_Category', $this->tableName, 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_ProductCharacteristic_TO_Category', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
