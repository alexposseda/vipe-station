<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\ProductModel
     */

    use yii\alexposseda\fileManager\FileManager;

    $gallery = $model->gallery;
    if(!empty($gallery)){
        $gallery = json_decode($gallery);
    }else{
        $gallery = [];
    }

    $js = <<<JS
$('.product-gallery-wrap').slick({
    dots: true,
    infinite: true,
    speed: 1000,
    slidesToShow: 1,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: false
});
JS;

    $this->registerJs($js);
?>

<div class="col s12 page-main valign-wrapper">
    <div class="content valign">
        <div class="row">
            <div class="col s12 m12 l6">
                <div class="product-gallery-wrap">
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
            </div>
            <div class="col s12 m12 l6">
                <div class="product-title">
                    <span class="fs20 fc-orange"><?= $model->title ?></span></div>
                <div class="product-price">
                    <span class="right fs20 fc-light-brown"><?= $model->base_price ?> UAH</span>
                    <div class="clearfix"></div>
                </div>
                <div class="product-description fs20 fc-dark-brown"><p><?= nl2br($model->description) ?></p></div>

                <div class="row">
                    <div class="col s12 m12 l4 push-l4 offset-l2">
                        <div class="input-group count-inp">
                            <span>-</span><input type="text" readonly value="1"><span>+</span>
                        </div>
                    </div>
                    <div class="col s12 m12 l4 pull-l4 ">
                        <div class="btn-buy center-align fs15 fc full-width">
                            <button data-target="buyproduct">Купить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
