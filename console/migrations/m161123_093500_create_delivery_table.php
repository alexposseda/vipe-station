<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%delivery}}`.
     */
    class m161123_093500_create_delivery_table extends Migration{
        protected $tableName = '{{%delivery}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id'          => $this->primaryKey(),
                'name'        => $this->string()
                                      ->notNull()
                                      ->unique(),
                'description' => $this->text()->notNull(),
                'price'       => $this->integer()->notNull(),
                'created_at'  => $this->integer(),
                'updated_at'  => $this->integer(),
            ], $tableOptions);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable($this->tableName);
        }
    }
