<?php

    use yii\db\Migration;

    /**
     * Handles dropping manufacturer from table `product`.
     */
    class m170103_104740_drop_manufacturer_column_from_product_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->dropColumn('{{%product}}', 'manufacturer_id');
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->addColumn('{{%product}}', 'manufacturer_id', $this->integer());
        }
    }
