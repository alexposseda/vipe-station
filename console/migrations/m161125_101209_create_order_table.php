<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%order}}`.
     */
    class m161125_101209_create_order_table extends Migration{
        protected $tableName = '{{%order}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id'            => $this->primaryKey(),
                'comment'       => $this->text(),
                'status'        => "ENUM ('active', 'deleted', 'aborted', 'sent', 'confirmed', 'finished', 'paid') NOT NULL DEFAULT 'active'",
                'delivery_type' => $this->integer()
                                        ->notNull(),
                'delivery_data' => $this->text()
                                        ->notNull(),
                'payment_id'  => $this->integer(),
                'total_cost'    => $this->float(),
                'created_at'    => $this->integer(),
                'updated_at'    => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_Order_TO_Payment', $this->tableName, 'payment_id', '{{%payment}}', 'id', 'SET NULL', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_Order_TO_Payment', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
