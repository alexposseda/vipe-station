<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%payment}}`.
     */
    class m161123_093550_create_payment_table extends Migration{
        protected $tableName = '{{%payment}}';

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
                'name' => $this->string()->notNull()->unique(),
                'description' => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropTable($this->tableName);
        }
    }
