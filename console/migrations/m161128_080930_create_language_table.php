<?php

use yii\db\Migration;

/**
 * Handles the creation of table `language`.
 */
class m161128_080930_create_language_table extends Migration
{
    protected $tableName = '{{%language}}';

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
            'code' => $this->string(4)->notNull()->unique(),
            'title' => $this->string(20)->notNull()->unique(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer()
        ]);
        $createdTime = time();
        $this->batchInsert($this->tableName, [
            'code',
            'title',
            'created_at',
            'updated_at'
        ], [
            [
                'ru',
                'russian',
                $createdTime,
                $createdTime
            ],
            [
                'ua',
                'ukrainian',
                $createdTime,
                $createdTime
            ]
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable($this->tableName);
    }
}
