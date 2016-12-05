<?php
//
//    use yii\db\Migration;
//
//    /**
//     * Handles the creation of table `{{%manufacturer}}`.
//     */
//    class m161123_094000_create_manufacturer_table extends Migration{
//        protected $tableName = '{{%manufacturer}}';
//
//        /**
//         * @inheritdoc
//         */
//        public function up(){
//            $tableOptions = null;
//            if($this->db->driverName === 'mysql'){
//                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
//            }
//            $this->createTable($this->tableName, [
//                'id' => $this->primaryKey(),
//                'name' => $this->string()->unique()->notNull(),
//                'created_at' => $this->integer(),
//                'updated_at' => $this->integer(),
//            ], $tableOptions);
//        }
//
//        /**
//         * @inheritdoc
//         */
//        public function down(){
//            $this->dropTable($this->tableName);
//        }
//    }
