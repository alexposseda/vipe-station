<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category_lang`.
 */
class m161128_081834_create_category_lang_table extends Migration
{
    protected $tableName = '{{%category_lang}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'language' => $this->string(4)->notNull(),
            'title' => $this->string(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_Category_Lang_TO_Category', $this->tableName, 'category_id', '{{%category}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Category_Lang_TO_Language', $this->tableName, 'language', '{{%language}}', 'code', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_Category_Lang_TO_Category', $this->tableName);
        $this->dropForeignKey('FK_Category_Lang_TO_Language', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
