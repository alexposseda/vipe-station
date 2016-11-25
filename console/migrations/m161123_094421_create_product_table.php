<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%product}}`.
     */
    class m161123_094421_create_product_table extends Migration{
        protected $tableName = '{{%product}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id'              => $this->primaryKey(),
                'title'           => $this->string()
                                          ->notNull()
                                          ->unique(),
                'gallery'         => $this->text(),
                'description'     => $this->text()
                                          ->notNull(),
                'base_price'      => $this->float()
                                          ->notNull()
                                          ->defaultValue(0),
                'base_quantity'   => $this->integer()
                                          ->notNull()
                                          ->defaultValue(0),
                'slug'            => $this->string()
                                          ->unique()
                                          ->notNull(),
                'manufacturer_id' => $this->integer(),
                'sales'           => $this->integer()
                                          ->defaultValue(0),
                'views'           => $this->integer()
                                          ->defaultValue(0),
                'seo_id'          => $this->integer()
                                          ->defaultValue(null),
                'created_at'      => $this->integer(),
                'updated_at'      => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_Product_TO_Seo', $this->tableName, 'seo_id', '{{%seo}}', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('FK_Product_TO_Manufacturer', $this->tableName, 'manufacturer_id', '{{%manufacturer}}', 'id', 'SET NULL', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_Product_TO_Seo', $this->tableName);
            $this->dropForeignKey('FK_Product_TO_Manufacturer', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
