<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_characteristic_lang}}`.
 */
class m161128_084417_create_product_characteristic_lang_table extends Migration
{
    protected $tableName = '{{%product_characteristic_lang}}';

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
            'product_characteristic_id' => $this->integer()->notNull(),
            'language' => $this->string(4)->notNull(),
            'title' => $this->string(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_Product_Characteristic_Lang_TO_Product_Characteristic', $this->tableName, 'product_characteristic_id', '{{%product_characteristic}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Product_Characteristic_Lang_TO_Language', $this->tableName, 'language', '{{%language}}', 'code', 'CASCADE', 'CASCADE');

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_Product_Characteristic_Lang_TO_Product_Characteristic', $this->tableName);
        $this->dropForeignKey('FK_Product_Characteristic_Lang_TO_Language', $this->tableName);

        $this->dropTable($this->tableName);
    }
}
