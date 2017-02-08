<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\ProductModel
     */

    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Url;

    \frontend\assets\ProductAsset::register($this);

    $gallery = $model->gallery;
    if(!empty($gallery)){
        $gallery = json_decode($gallery);
    }else{
        $gallery = [];
    }

    $optionsList = \common\models\ProductModel::getOptions($model);

    $options = [];
    foreach($optionsList as $prod_id => $opts){
        foreach($opts as $opt){
            $options[$opt['id']][$opt['value']] = $opt['value'];
        }
    }

    $selectedOptions = [];
    foreach($model->productCharacteristicItems as $productCharacteristicItem){
        if($productCharacteristicItem->characteristic->isOption){
            $selectedOptions[$productCharacteristicItem->characteristic_id] = [$model->id];
        }
    }

    foreach($options as $key => $v){
        $options[$key] = array_unique($v);
    }

?>
<?php \yii\widgets\Pjax::begin([
                                   'id'              => 'productPjaxContainer',
                                   'enablePushState' => true,
                               ]); ?>
    <div class="col s12 page-main valign-wrapper" id="product" data-url="<?= \yii\helpers\Url::to([
                                                                                                      '/catalog/product',
                                                                                                      'slug' => $model->slug
                                                                                                  ]) ?>">
        <div class="content valign">
            <div class="row">
                <div class="col s12 m12 l6">
                    <div class="row product-gallery-wrap">
                        <?php
                            if(!empty($gallery)):
                                foreach($gallery as $pic):
                                    ?>
                                    <div class="product-gallery-item">
                                        <img src="<?= FileManager::getInstance()
                                                                 ->getStorageUrl().$pic ?>" alt="<?= $model->title ?>">
                                    </div>
                                    <?php
                                endforeach;
                            else:
                                ?>
                                <div class="product-gallery-item">
                                    <img src="<?= $model->getCover() ?>" alt="no picture>">
                                </div>
                            <?php endif; ?>
                    </div>
                    <div class="row characteristics">
                        <table class="responsive-table bordered">
                            <caption class="fs20 fc-light-brown">Характеристики</caption>
                            <?php foreach($model->productCharacteristicItems as $productCharacteristicItem): ?>
                                <tr>
                                    <td><?= $productCharacteristicItem->characteristic->title ?></td>
                                    <td><?= $productCharacteristicItem->value ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="product-title">
                        <span class="fs20 fc-orange"><?= $model->title ?></span>
                    </div>
                    <div class="product-price">
                        <span class="right fs20 fc-light-brown"><?= $model->base_price ?> UAH</span>
                        <div class="clearfix"></div>
                    </div>
                    <div class="product-description fs20 fc-dark-brown"><p><?= nl2br($model->description) ?></p></div>

                    <div class="row options">
                        <?php
                            $selectForm = \yii\widgets\ActiveForm::begin([
                                                                             'action'  => '/catalog/get-product',
                                                                             'method'  => 'get',
                                                                             'options' => [
                                                                                 'data-pjax' => true,
                                                                                 'id'        => 'selectOptionForm'
                                                                             ]
                                                                         ]);
                            foreach($model->productCharacteristicItems as $productCharacteristicItem):
                                if($productCharacteristicItem->characteristic->isOption):
                                    $selectedItems = $selectedOptions[$productCharacteristicItem->characteristic_id];
                                    $items = $options[$productCharacteristicItem->characteristic_id];
                                    ?>
                                    <div class="input-field">
                                        <span class="fs20 fc-dark-brown label-for-select"><?= $productCharacteristicItem->characteristic->title ?></span>
                                        <div class="option-select">
                                            <?= \yii\helpers\Html::dropDownList('options['.$productCharacteristicItem->characteristic_id.']',
                                                                                $selectedItems, $items, []) ?>
                                        </div>
                                    </div>
                                    <?php
                                endif;
                            endforeach;
                            \yii\widgets\ActiveForm::end();
                        ?>
                    </div>
                    <div class="row">
                        <div class="col s12 m12 l4 push-l4 offset-l2">
                            <div class="input-group count-inp">
                                <span class="quantity-btn" data-action="minus">-</span>
                                <input type="text" readonly value="1" id="product-quantity" data-base_quantity="<?= $model->base_quantity?>">
                                <span class="quantity-btn" data-action="plus">+</span>
                            </div>
                        </div>
                        <div class="col s12 m12 l4 pull-l4 ">
                            <div class="btn-buy center-align fs15 fc full-width">
                                <input type="hidden" id="product_id" value="<?= $model->id ?>">
                                <button data-target="buyproduct" id="addToCart" data-url="<?= Url::to(['cart/add-to-cart']) ?>">Купить</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php \yii\widgets\Pjax::end(); ?>