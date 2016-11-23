<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%product_characteristic_item}}`.
     */
    class m161123_124309_create_product_characteristic_item_table extends Migration{
        protected $tableName = '{{%product_characteristic_item}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id'                => $this->primaryKey(),
                'characteristic_id' => $this->integer()
                                            ->notNull(),
                'product_id'        => $this->integer()
                                            ->notNull(),
                'value'             => $this->string()->notNull(),
                'created_at'        => $this->integer(),
                'updated_at'        => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_CharacteristicItem_TO_Characteristic', $this->tableName, 'characteristic_id', '{{%product_characteristic}}',
                                 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('FK_CharacteristicItem_TO_Product', $this->tableName, 'product_id', '{{%product}}',
                                 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_CharacteristicItem_TO_Characteristic', $this->tableName);
            $this->dropForeignKey('FK_CharacteristicItem_TO_Product', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
