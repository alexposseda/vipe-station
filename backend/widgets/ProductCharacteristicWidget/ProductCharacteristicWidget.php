<?php

    namespace backend\widgets\ProductCharacteristicWidget;

    use common\models\CategoryModel;
    use common\models\ProductCharacteristicModel;
    use yii\base\Widget;
    use yii\helpers\Html;

    class ProductCharacteristicWidget extends Widget{
        public $id;

        public function run(){

            if($this->id != null){
                $div = '';
                $this->Characteristic($this->id, $div);
                return $div;
            }else{
                return false;
            }


        }

        public function Characteristic($id, $div){
            /** @var CategoryModel $category */
            $category = CategoryModel::findOne($id);
            if($category->getProductCharacteristics()->sql !== null){
                /** @var ProductCharacteristicModel $characteristic */
                /** @var ProductCharacteristicModel[] $characteristics */
                $characteristics = $category->getProductCharacteristics();
                foreach($characteristics as $characteristic){
                    $div .= Html::tag('div', $characteristic->title, ['class' => 'col-md-1']);
                }

                return $div;
            }
            if($category->parent != null){
                $this->Characteristic($category->parent, $div);
            }
        }
    }