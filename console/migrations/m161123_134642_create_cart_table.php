<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%cart}}`.
     */
    class m161123_134642_create_cart_table extends Migration{
        protected $tableName = '{{%cart}}';

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
                'user_id'    => $this->integer(),
                'guest_id'   => $this->string(),
                'product_id' => $this->integer()->notNull(),
                'options'    => $this->string()->defaultValue(json_encode([])),
                'quantity'   => $this->integer()->notNull(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_Cart_TO_User', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_Cart_TO_User', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
