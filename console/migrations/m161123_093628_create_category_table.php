<?php

    use yii\db\Migration;

    /**
     * Handles the creation of table `{{%category}}`.
     */
    class m161123_093628_create_category_table extends Migration{
        protected $tableName = '{{%category}}';

        /**
         * @inheritdoc
         */
        public function up(){
            $this->createTable($this->tableName, [
                'id'         => $this->primaryKey(),
                'title'      => $this->string()
                                     ->unique()
                                     ->notNull(),
                'parent'     => $this->integer(),
                'slug'       => $this->string()
                                     ->unique()
                                     ->notNull(),
                'seo_id'     => $this->integer()
                                     ->defaultValue(null),
                'created_at' => $this->integer(),
                'updated_at' => $this->integer(),
            ]);

            $this->addForeignKey('FK_CATEGORY_PARENT_ID', $this->tableName, 'parent', $this->tableName, 'id', 'SET NULL', 'CASCADE');
            $this->addForeignKey('FK_Category_TO_Seo', $this->tableName, 'seo_id', '{{%seo}}', 'id', 'SET NULL', 'CASCADE');

        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropForeignKey('FK_CATEGORY_PARENT_ID', $this->tableName);
            $this->dropForeignKey('FK_Category_TO_Seo', $this->tableName);
            $this->dropTable($this->tableName);
        }
    }
