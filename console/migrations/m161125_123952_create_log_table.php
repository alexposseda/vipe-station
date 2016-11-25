<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%log}}`.
     */
    class m161125_123952_create_log_table extends Migration{
        protected $tableName = '{{%log}}';

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
                'action'      => $this->string(),
                'action_data' => $this->text(),
                'initializer' => "ENUM ('system', 'user', 'manager', 'admin) NOT NULL DEFAULT 'system'",
                'user_id'     => $this->integer(),
                'created_at'  => $this->integer(),
                'updated_at'  => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_Log_TO_User', $this->tableName, 'user_id', '{{%user}}', 'id', 'SET NULL', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_Log_TO_User', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
