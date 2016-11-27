<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%product_option}}`.
     */
    class m161123_125107_create_product_option_table extends Migration{
        protected $tableName = '{{%product_option}}';

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
                'delta_price'       => $this->float()
                                            ->defaultValue(0),
                'quantity'          => $this->integer()
                                            ->defaultValue(0),
                'created_at'        => $this->integer(),
                'updated_at'        => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_ProductOption_TO_ProductCharacteristic', $this->tableName, 'characteristic_id', '{{%product_characteristic}}',
                                 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('FK_ProductOption_TO_Product', $this->tableName, 'product_id', '{{%product}}',
                                 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_ProductOption_TO_ProductCharacteristic', $this->tableName);
            $this->dropForeignKey('FK_ProductOption_TO_Product', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
