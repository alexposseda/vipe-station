<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_client}}`.
 */
class m161123_085020_create_client_table extends Migration
{
    protected $tableName = '{{%client}}';

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
            'user_id' => $this->integer()
                ->notNull()->unique(),
            'name' => $this->string()
                ->notNull(),
            'phones' => $this->string(),
            'birthday' => $this->integer(),
            'delivery_data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('FK_Client_TO_User', $this->tableName, 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        $this->insert($this->tableName, [
            'user_id' => 1,
            'name' => 'admin',
            'phones' => '{{"000 000 0000"}}',
            'birthday' => strtotime('29/09/1979'),
            'delivery_data' => '{{"city":"kiev"}}',
            'created_at' => time(),
            'updated_at' => time()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('FK_Client_TO_User', $this->tableName);
        $this->dropTable($this->tableName);
    }
}
