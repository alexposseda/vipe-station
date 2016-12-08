<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_option_lang}}`.
 */
class m161128_084715_create_product_option_lang_table extends Migration
{
    protected $tableName = '{{%product_option_lang}}';

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
            'product_option_id' => $this->integer()->notNull(),
            'language' => $this->string(4)->notNull(),
            'value' => $this->string(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_Product_Option_Lang_TO_Product_Option', $this->tableName, 'product_option_id', '{{%product_option}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Product_Option_Lang_TO_Language', $this->tableName, 'language', '{{%language}}', 'code', 'CASCADE', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_Product_Option_Lang_TO_Product_Option', $this->tableName);
        $this->dropForeignKey('FK_Product_Option_Lang_TO_Language', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
