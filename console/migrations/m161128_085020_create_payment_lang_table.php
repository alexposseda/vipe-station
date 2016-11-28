<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment_lang}}`.
 */
class m161128_085020_create_payment_lang_table extends Migration
{
    protected $tableName = '{{%payment_lang}}';

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
            'payment_id' => $this->integer()->notNull(),
            'language' => $this->integer()->notNull(),

            'name' => $this->string(),
            'description' => $this->text(),

            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_Payment_Lang_TO_Payment', $this->tableName, 'payment_id', '{{%payment}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_Payment_Lang_TO_Language', $this->tableName, 'language', '{{%language}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_Payment_Lang_TO_Product_Option', $this->tableName);
        $this->dropForeignKey('FK_Payment_Lang_TO_Language', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
