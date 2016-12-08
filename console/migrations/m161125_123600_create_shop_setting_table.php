<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%setting}}`.
     */
    class m161125_123600_create_shop_setting_table extends Migration{
        protected $tableName = '{{%setting}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'key'        => $this->string(20),
                'value'      => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addPrimaryKey('PK_ShopSetting', $this->tableName, 'key');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable($this->tableName);
        }
    }
