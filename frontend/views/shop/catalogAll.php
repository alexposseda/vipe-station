<?php
    /**
     * @var $this    \yii\web\View
     * @var $catalog \yii\data\ActiveDataProvider
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Html;
    use yii\helpers\Url;

?>

<div class="col s12 page-main ">
    <ul class="sort sub-title white-text">
        <li class="border-r">
            <a href="">Сортировать по</a>
        </li>
        <li><a href="<?= Url::to(['catalog', 'sort' => 'created_at']) ?>">Новинкам</a></li>
        <li><a href="<?= Url::to(['catalog', 'sort' => 'sales']) ?>">Популярности</a></li>
        <li><a href="<?= Url::to(['catalog', 'sort' => 'stock']) ?>">Скидкам</a></li>
        <li><a href="<?= Url::to(['catalog', 'sort' => 'base_price']) ?>">Цене</a></li>
    </ul>
    <div class="page-device-modal valign-wrapper hide">
        <div class="img-wrap-device valign">
            <img src="../images/catalog1.png" alt="" class="modalImage">
        </div>
        <div class="wrap-device-content valign">
            <img src="../images/close.png" alt="" class="close-modal">
            <p class="modal-nameProduct fs30 fc-orange">Найменование</p>
            <span class="right-align modal-priceProduct fc-brown fs20">17$</span>
            <p class="modal-contentProduct fs20 fc-dark-brown">Lorem ipsum dolor sit amet,
                consectetur
                adipisicing elit. A aperiam autem delectus dignissimos, dolore enim error eum
                expedita
                fugit iusto libero, non nulla ratione repudiandae similique tenetur vel veritatis
                vero.</p>
            <form action="">
                <div class="input-field col s12">
                    <select>
                        <option value="" disabled="" selected="">Выберите</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label class="">Вкус</label>

                </div>
                <div class="input-field col s12">
                    <select>
                        <option value="" disabled="" selected="">Выберите</option>
                        <option value="1">Option 1</option>
                        <option value="2">Option 2</option>
                        <option value="3">Option 3</option>
                    </select>
                    <label>Объем</label>
                </div>
            </form>
            <div class="center-align">
                <button class="btn-modal-buy fs20 fc-brown">Купить</button>
                <div class="modal-curent-btn">
                    <span>-</span>
                    <span>6</span>
                    <span>+</span>
                </div>

            </div>

        </div>
    </div>

    <div class="content products-wrapper-isotope valign">
        <?php foreach($catalog->models as $product): ?>
            <div class="wrap-overflow product">
                <div class="wrap-items">
                    <div class="wrap-items-first-section left center-align">
                        <div class="product-img">
                            <img src="<?= FileManager::getInstance()
                                                     ->getStorageUrl().$product->cover ?>">
                        </div>
                        <div class="wrap-text-block">
                            <div class="product-title fs20 fc-orange"><?= Html::encode($product->title) ?></div>
                            <div class="product-brand fs15 fc-dark-brown"><?= Html::encode($product->brand->title) ?></div>
                            <div class="product-price fs20 fc-light-brown"><?= $product->base_price.' '.Yii::t('models/cart', 'UAH') ?></div>
                        </div>

                    </div>
                    <div class="wrap-items-second-section left">
                        <div class="product-title">
                            <a href="<?= Url::to(['shop/product', 'id' => $product->id]) ?>"
                               class="fs20 fc-orange"><?= Html::encode($product->title) ?></a></div>
                        <div class="product-price">
                            <span class="right fs20 fc-light-brown"><?= $product->base_price.' '.Yii::t('models/cart', 'UAH') ?></span>
                            <div class="clearfix"></div>
                        </div>

                        <div class="product-description fs15 fc-dark-brown"><p><?= Html::encode($product->description) ?></p></div>
                        <div class="btn-buy center-align fs15 fc">
                            <button data-target="buyproduct" class="modal-trigger">Купить</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="count-page fs25">
        <span><?= $catalog->pagination->page ? $catalog->pagination->page : 1 ?> / </span>
        <span><?= $catalog->pagination->pageCount ?></span>
        <div></div>
    </div>
    <!--</div>-->
</div>

