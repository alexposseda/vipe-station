<?php

    namespace common\models\stock_policys;

    use common\models\StockPolicyModel;

    class DiscountStockPolicy extends StockPolicyModel{
        public $valueStock;

        public function getStockPrice(){
            return $this->valueStock;
        }
    }