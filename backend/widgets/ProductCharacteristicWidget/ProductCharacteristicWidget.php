<?php

    namespace backend\widgets\ProductCharacteristicWidget;

    use common\models\CategoryModel;
    use common\models\ProductCharacteristicModel;
    use yii\base\Widget;
    use yii\helpers\Html;

    class ProductCharacteristicWidget extends Widget{
        public $id;

        public function run(){

            $div = '';
            $this->Characteristic($this->id, $div);
            return $div;
        }

        public function Characteristic($id, $div){
            /** @var CategoryModel $category */
            $category = CategoryModel::findOne($id);
            if($characteristics = $category->getProductCharacteristics() !== null){
                /** @var ProductCharacteristicModel $characteristic */
                /** @var ProductCharacteristicModel[] $characteristics */
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