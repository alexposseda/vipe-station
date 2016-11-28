<?php

    use yii\db\Migration;

    class m130524_201442_init extends Migration{
        protected $tableName = '{{%user}}';

        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable($this->tableName, [
                'id'                   => $this->primaryKey(),
                'auth_key'             => $this->string(32)
                                               ->notNull(),
                'password_hash'        => $this->string()
                                               ->notNull(),
                'password_reset_token' => $this->string()
                                               ->unique(),
                'email'                => $this->string()
                                               ->notNull()
                                               ->unique(),
                'status'               => $this->smallInteger()
                                               ->notNull()
                                               ->defaultValue(10),
                'created_at'           => $this->integer(),
                'updated_at'           => $this->integer(),
            ], $tableOptions);

            $adminEmail = '';
            while(empty($adminEmail)){
                echo 'Enter admin email: ';
                $adminEmail = trim(fgets(STDIN));
                if(empty($adminEmail)){
                    echo "Email must be not empty!\n";
                }
            }
            $adminPassword = '';
            while(empty($adminPassword)){
                echo 'Enter admin password: ';
                $adminPassword = trim(fgets(STDIN));
                if(empty($adminPassword)){
                    echo "Password must be not empty!\n";
                }
            }

            $this->insert($this->tableName, [
                'auth_key'      => Yii::$app->security->generateRandomString(),
                'password_hash' => Yii::$app->security->generatePasswordHash($adminPassword),
                'email'         => $adminEmail,
                'created_at'    => time(),
                'updated_at'    => time()
            ]);
        }

        public function down(){
            $this->dropTable('{{%user}}');
        }
    }
