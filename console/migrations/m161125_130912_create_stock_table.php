<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%stock}}`.
     */
    class m161125_130912_create_stock_table extends Migration{
        protected $tableName = '{{%stock}}';

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
                'policy_id'   => $this->integer(),
                'title'       => $this->string()
                                      ->notNull()
                                      ->unique(),
                'slug'        => $this->string()
                                      ->notNull()
                                      ->unique(),
                'cover'       => $this->string()->notNull(),
                'description' => $this->text()->notNull(),
                'date_start' => $this->integer(),
                'date_end' => $this->integer(),
                'status' => "ENUM ('active', 'inactive') NOT NULL DEFAULT 'active'",
                'stock_value' => $this->text(),
                'created_at'  => $this->integer(),
                'updated_at'  => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_Stock_TO_StockPolicy', $this->tableName, 'policy_id', '{{%stock_policy}}', 'id', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_Stock_TO_StockPolicy', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
