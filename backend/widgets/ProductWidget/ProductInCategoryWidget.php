<?php

    namespace backend\widgets\ProductWidget;

    use Yii;
    use yii\base\Widget;
    use yii\helpers\Html;
    use common\models\CategoryModel;

    class ProductInCategoryWidget extends Widget{
        public $id;

        public function run(){
            $products = CategoryModel::findOne($this->id)->products;
            $th = Html::tag('th', 'ID', [
                'style' => [
                    'width'     => '2%',
                    'max-width' => '50px'
                ]
            ]);
            $th .= Html::tag('th', Yii::t('models/product', 'Title'), [
                'style' => [
                    'width'     => '30%',
                    'max-width' => '150px'
                ]
            ]);
            $th .= Html::tag('th', Yii::t('models/product', 'Description'), [
                'style' => [
                    'width'     => '78%',
                    'max-width' => '150px'
                ]
            ]);
            $tr = Html::tag('tr', $th);
            foreach($products as $product){
                $td = Html::tag('td', $product->id, [
                    'style' => [
                        'vertical-align' => 'middle'
                    ]
                ]);
                $td .= Html::tag('td', $product->title, [
                    'style' => [
                        'vertical-align' => 'middle'
                    ]
                ]);
                $td .= Html::tag('td', $product->description, [
                    'style' => [
                        'vertical-align' => 'middle'
                    ]
                ]);
                $tr .= Html::tag('tr', $td);
            }
            return Html::tag('table', $tr, ['class' => 'table table-striped table-bordered']);
        }
    }
