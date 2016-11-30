<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%brand}}`.
     */
    class m161129_073105_create_brand_table extends Migration{
        protected $tableName = '{{%brand}}';

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
                'title'       => $this->string()
                                      ->unique()
                                      ->notNull(),
                'cover'       => $this->string(),
                'description' => $this->text(),
                'slug'        => $this->string()
                                      ->unique()
                                      ->notNull(),
                'seo_id'      => $this->integer(),
                'created_at'  => $this->integer(),
                'updated_at'  => $this->integer(),
            ], $tableOptions);

            $this->addColumn('{{%product}}', 'brand_id', 'integer');
            $this->addForeignKey('FK_Brand_To_Seo', $this->tableName, 'seo_id', '{{%seo}}', 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('FK_Product_To_Brand', '{{%product}}', 'brand_id', $this->tableName, 'id', 'SET NULL', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropColumn('{{%product}}', 'brand_id');
            $this->dropForeignKey('FK_Product_To_Brand', '{{%product}}');
            $this->dropForeignKey('FK_Brand_To_Seo', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
