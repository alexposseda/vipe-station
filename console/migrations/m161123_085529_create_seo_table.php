<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%seo}}`.
     */
    class m161123_085529_create_seo_table extends Migration{
        protected $tableName = '{{%seo}}';

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
                'title' => $this->string(),
                'keywords' => $this->string(),
                'description' => $this->string(500),
                'seo_block' => $this->text(),
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
