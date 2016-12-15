<?php
    /**
     * @var $this    \yii\web\View
     * @var $catalog \yii\data\ActiveDataProvider
     */
    use yii\alexposseda\fileManager\FileManager;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ListView;
    use yii\widgets\Pjax;

    $sorting = Yii::$app->request->get('sort');
?>
<div class="col s12 page-main ">
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
    <?= ListView::widget([
                             'dataProvider' => $catalog,
                             'itemView'     => '_catalog_item',
                             'itemOptions'  => ['class' => 'wrap-overflow product'],
                             'layout'       => "<div class='sort-wraper sub-title white-text'><span class='sorted-by border-r'>".Yii::t('models/product','Sort by')."</span>{sorter}</div>\n<div class='content products-wrapper-isotope valign'>{items}</div>\n{summary}",
                             'sorter'       => ['options' => ['class'=>'sort ']],
                             'summary'      => '<div class="count-page fs25">{page} / {pageCount}</div>',
                         ]) ?>
</div>
