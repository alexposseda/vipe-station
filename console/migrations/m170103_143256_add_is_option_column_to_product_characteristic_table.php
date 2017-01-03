<?php

    use yii\db\Migration;

    /**
     * Handles adding is_option to table `product_characteristic`.
     */
    class m170103_143256_add_is_option_column_to_product_characteristic_table extends Migration{
        /**
         * @inheritdoc
         */
        public function up(){
            $this->addColumn('{{%product_characteristic}}', 'isOption', $this->boolean());
        }

        /**
         * @inheritdoc
         */
        public function down(){
            $this->dropColumn('{{%product_characteristic}}', 'isOption');
        }
    }
