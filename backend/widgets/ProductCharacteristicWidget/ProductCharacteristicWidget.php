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
                return $div = $this->Characteristic($this->id, $div);
            }else{
                return false;
            }


        }

        public function Characteristic($id, $div){
            /** @var CategoryModel $category */
            $category = CategoryModel::findOne($id);
            $characteristics = $category->productCharacteristics;
            if(!empty($category->productCharacteristics)){
                /** @var ProductCharacteristicModel $characteristic */
                /** @var ProductCharacteristicModel[] $characteristics */
                $characteristics = $category->productCharacteristics;
                foreach($characteristics as $characteristic){
                    $div .= Html::tag('div', $characteristic->title, ['class' => 'col-md-1 panel  panel-success']);
                }

                return $div;
            }
            if($category->parent != null){
                $this->Characteristic($category->parent, $div);
            }
        }
    }