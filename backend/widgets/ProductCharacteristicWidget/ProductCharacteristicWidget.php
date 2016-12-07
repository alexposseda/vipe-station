<?php

    namespace backend\widgets\ProductCharacteristicWidget;

    use common\models\CategoryModel;
    use common\models\ProductCharacteristicModel;
    use yii\base\Widget;
    use yii\helpers\Html;

    class ProductCharacteristicWidget extends Widget{
        public $id;

        public function run(){

            return $this->Characteristic($this->id);
        }

        public function Characteristic($id){
            if(!empty($category = CategoryModel::findOne($id))){
                $div = '';
                if(!empty($category->productCharacteristics)){
                    /** @var ProductCharacteristicModel $characteristic */
                    /** @var ProductCharacteristicModel[] $characteristics */
                    $characteristics = $category->productCharacteristics;
                    foreach($characteristics as $characteristic){
                        $div .= Html::tag('div', $characteristic->title, ['class' => 'col-md-1 panel  panel-success']);
                    }
                    $div .= Html::tag('div', '', [
                        'class' => 'col-md-1 panel  panel-success',
                        'style' => ['width' => '5%']
                    ]);
                }
                if($category->parent != null){
                    $div .= $this->Characteristic($category->parent);
                }

                return $div;
            }
        }
    }