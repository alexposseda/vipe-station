<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%action_product}}`.
     * Has foreign keys to the tables:
     *
     * - `product`
     * - `action`
     */
    class m161123_143223_create_action_product_table extends Migration{
        protected $tableName = '{{%action_product}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'product_id' => $this->integer(),
                'action_id'  => $this->integer(),

                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addPrimaryKey('PK_ACTION_PRODUCT', $this->tableName, [
                'product_id',
                'action_id'
            ]);

            $this->addForeignKey('fk-action_product-product_id', $this->tableName, 'product_id', '{{%product}}', 'id', 'CASCADE');

            $this->addForeignKey('fk-action_product-action_id', $this->tableName, 'action_id', '{{%action}}', 'id', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('fk-action_product-product_id', $this->tableName);
            $this->dropForeignKey('fk-action_product-action_id', $this->tableName);

            $this->dropTable($this->tableName);
        }
    }
