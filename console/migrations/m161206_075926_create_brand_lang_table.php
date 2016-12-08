<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%brand_lang}}`.
     */
    class m161206_075926_create_brand_lang_table extends Migration{
        protected $tableName = '{{%brand_lang}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $tableOptions = null;
            if($this->db->driverName === 'mysql'){
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'brand_id' => $this->integer()->notNull(),
                'language' => $this->string(4)->notNull(),
                'title'       => $this->string(),
                'description' => $this->text(),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ], $tableOptions);

            $this->addForeignKey('FK_Brand_Lang_TO_Brand', $this->tableName, 'brand_id', '{{%brand}}', 'id', 'CASCADE', 'CASCADE');
            $this->addForeignKey('FK_Brand_Lang_TO_Language', $this->tableName, 'language', '{{%language}}', 'code', 'CASCADE', 'CASCADE');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_Brand_Lang_TO_Brand', $this->tableName);
            $this->dropForeignKey('FK_Brand_Lang_TO_Language', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
