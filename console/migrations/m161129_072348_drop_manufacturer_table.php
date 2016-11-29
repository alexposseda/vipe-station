<?php

    use yii\db\Migration;

    /**
     * Handles the dropping of table `manufacturer`.
     */
    class m161129_072348_drop_manufacturer_table extends Migration{
        protected $tableName = '{{%stock_lang}}';
        /**
         * @inheritdoc
         */
        public function up(){
            $this->dropForeignKey('FK_Product_TO_Manufacturer', '{{%product}}');
            $this->dropColumn('{{%product}}', 'manufacturer_id');
            $this->dropTable($this->tableName);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'name' => $this->string()->unique()->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addColumn('{{%product}}', 'manufacturer_id', 'integer');
            $this->addForeignKey('FK_Product_TO_Manufacturer', '{{%product}}', 'manufacturer_id', $this->tableName, 'id', 'SET NULL', 'CASCADE');

        }
    }
