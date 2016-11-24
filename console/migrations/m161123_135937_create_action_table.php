<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%action}}`.
     */
    class m161123_135937_create_action_table extends Migration{
        protected $tableName = '{{%action}}';

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
                'title'       => $this->string(),
                'name'        => $this->string()
                                      ->notNull()
                                      ->unique(),
                'description' => $this->text()
                                      ->notNull(),
                'volume'      => $this->integer(),
                'icon'        => $this->string(),
                'status'      => 'ENUM("active", "inactive", "blocked")',

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
