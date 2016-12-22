<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\ProductModel
     */
    use common\models\forms\CartForm;
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    use yii\helpers\Url;

    $cartModel = new CartForm();
?>
<div class="wrap-items col-lg-3">
    <?php $cartForm = ActiveForm::begin(['action' => Url::to(['/cart/add-to-cart'], 1), 'options' => ['data-pjax' => 1]]) ?>
    <div class="wrap-items-first-section left center-align">
        <div class="product-img">
            <img src="<?= $model->cover ?>">
        </div>
        <div class="wrap-text-block">
            <div class="product-title fs20 fc-orange">
                <?= Html::encode($model->title) ?>
            </div>
            <div class="product-characteristics ">
                <?php if(!empty($characteristicArrayMap = $cartModel->characteristics($model))): ?>
                    <?= $cartForm->field($cartModel, 'characteristic_id')
                                 ->checkboxList($characteristicArrayMap) ?>
                <?php endif; ?>
            </div>
            <div class="product-options">
                <?php if(!empty($characteristicArrayMap = $cartModel->options($model))): ?>
                    <?= $cartForm->field($cartModel, 'option_id')
                                 ->checkboxList($characteristicArrayMap) ?>
                <?php endif; ?>
            </div>
            <div class="product-brand fs15 fc-dark-brown">
                <?= Html::encode($model->brand->title) ?>
            </div>
            <div class="product-price fs20 fc-light-brown">
                <?= $model->base_price.' '.Yii::t('models/cart', 'UAH') ?>
            </div>
            <div class="product-quantity">
                <?= $cartForm->field($cartModel, 'quantity')
                             ->input('number') ?>
            </div>
            <?= Html::activeHiddenInput($cartModel, 'product_id', ['value' => $model->id]) ?>
        </div>
        <div class="btn-buy center-align fs15 fc">
            <?= Html::submitButton('Купить', ['class' => 'btn btn-primary submit']) ?>
            <?php Html::a('Купить', ['cart/add-to-cart', 'product_id' => $model->id, 'options' => '{[de:de]}', 'quantity' => 1],
                          ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end() ?>
    <div class="clearfix"></div>
</div>
