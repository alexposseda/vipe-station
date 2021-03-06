<?php
    /**
     * @var $this  \yii\web\View
     * @var $model \common\models\forms\OrderForm
     */
    use yii\helpers\Url;

?>
<div dir="ltr"
     style="background-color:#f5f5f5;margin:0;padding:70px 0 70px 0;width:100%">
    <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
        <tbody>
        <tr>
            <td align="center" valign="top">
                <table border="0" cellpadding="0" cellspacing="0" width="600"
                       style="background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:3px!important">
                    <tbody>
                    <tr>
                        <td align="center" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="600"
                                   style="background-color:#8E5D36;border-radius:3px 3px 0 0!important;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif">
                                <tbody>
                                <tr>
                                    <td style="padding:36px 48px;display:block">
                                        <h1 style="color:#ffffff;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left">
                                            Спасибо за Ваш заказ</h1>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">
									<span><font color="#888888">
										</font></span>
                            <table border="0" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                <tr>
                                    <td valign="top"
                                        style="background-color:#fdfdfd">
												<span><font color="#888888">
													</font></span>
                                        <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td valign="top" style="padding:48px">
                                                    <div style="color:#737373;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left">
                                                        <p style="margin:0 0 16px">Мы получили Ваш заказ. Для удобства, детали заказа приведены
                                                            ниже:</p>
                                                        <h2 style="color:#3B2313;display:block;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                            <a href="#"
                                                               style="color:#3B2313;font-weight:normal;text-decoration:underline"
                                                               target="_blank">Заказ №<?= $model->order->id ?></a> (
                                                            <time datetime="<?= date(DATE_ATOM, $model->order->created_at) ?>"></time>
                                                            )
                                                        </h2>

                                                        <table cellspacing="0"
                                                               cellpadding="6"
                                                               style="width:100%;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;color:#737373;border:1px solid #e4e4e4"
                                                               border="1">
                                                            <thead>
                                                            <tr>
                                                                <th scope="col"
                                                                    style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    Товар
                                                                </th>
                                                                <th scope="col"
                                                                    style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    Количество
                                                                </th>
                                                                <th scope="col"
                                                                    style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    Цена
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach($model->orderData as $od): ?>
                                                                <tr>
                                                                    <td
                                                                            style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;word-wrap:break-word;color:#737373;padding:12px">
                                                                        <?= $od->product->title ?><br>
                                                                        <small></small>
                                                                    </td>
                                                                    <td
                                                                            style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;color:#737373;padding:12px">
                                                                        <?= $od->quantity ?>
                                                                    </td>
                                                                    <td
                                                                            style="text-align:left;vertical-align:middle;border:1px solid #eee;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;color:#737373;padding:12px">
                                                                        <span><?= $od->price*$od->quantity ?>&nbsp;<span><?= Yii::t('models/cart', 'UAH') ?></span></span>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                            </tbody>
                                                            <tfoot>
                                                            <tr>
                                                                <th scope="row"
                                                                    colspan="2"
                                                                    style="text-align:left;border-top-width:4px;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    Итог:
                                                                </th>
                                                                <td style="text-align:left;border-top-width:4px;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    <span><?= $model->order->getOrderDatas()
                                                                                           ->sum('price*quantity') ?>&nbsp;<span><?= Yii::t('models/cart',
                                                                                                                                   'UAH') ?></span></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"
                                                                    colspan="2"
                                                                    style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    Способ оплаты:
                                                                </th>
                                                                <td style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    <?= $model->order->payment->name ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"
                                                                    colspan="2"
                                                                    style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    Тип доставки и цена:
                                                                </th>
                                                                <td style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    <span><?= $model->order->delivery->name.' '.$model->order->delivery->price ?>
                                                                        <span><?= Yii::t('models/cart', 'UAH') ?></span></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row"
                                                                    colspan="2"
                                                                    style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    Всего:
                                                                </th>
                                                                <td style="text-align:left;color:#737373;border:1px solid #e4e4e4;padding:12px">
                                                                    <span><?= $model->order->total_cost ?>&nbsp;<span><?= Yii::t('models/cart',
                                                                                                                                 'UAH') ?></span></span>
                                                                </td>
                                                            </tr>
                                                            </tfoot>
                                                        </table>
                                                        <h2 style="color:#3B2313;display:block;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                            Реквизиты покупателя</h2>
                                                        <ul>
                                                            <li>
                                                                <strong>Email:</strong> <span
                                                                        style="color:#505050;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif"><a
                                                                            href="mailto:<?= $model->client->email ?>"
                                                                            target="_blank"><?= $model->client->email ?></a></span>
                                                            </li>
                                                            <li>
                                                                <strong>Тел:</strong> <span
                                                                        style="color:#505050;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif"><a
                                                                            href="tel:<?= $model->client->phone ?>"
                                                                            target="_blank"><?= $model->client->phone ?></a></span>
                                                            </li>
                                                        </ul>
                                                        <span><font color="#888888">
			</font></span>
                                                        <table cellspacing="0"
                                                               cellpadding="0" style="width:100%;vertical-align:top"
                                                               border="0">
                                                            <tbody>
                                                            <tr>
                                                                <td valign="top"
                                                                    width="50%">
                                                                    <h3 style="color:#3B2313;display:block;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left">
                                                                        Адрес</h3>

                                                                    <p style="color:#505050;font-family:'Helvetica Neue',Helvetica,Roboto,Arial,sans-serif;margin:0 0 16px">
                                                                        <?= $model->client->name ?><br><?= $model->deliveryData->address ?>
                                                                        <br><?= $model->deliveryData->city ?><br></p><span><font
                                                                                color="#888888"></font></span></td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <span><font color="#888888">
</font></span></div>
                                                    <span><font color="#888888">
														</font></span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <span><font color="#888888">

</font></span></td>
                                </tr>
                                </tbody>
                            </table>
                            <span><font color="#888888">

</font></span></td>
                    </tr>
                    <tr>
                        <td align="center" valign="top">

                            <table border="0" cellpadding="10" cellspacing="0" width="600">
                                <tbody>
                                <tr>
                                    <td valign="top" style="padding:0">
                                        <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                            <tbody>
                                            <tr>
                                                <td colspan="2" valign="middle"
                                                    style="padding:0 48px 48px 48px;border:0;color:#99b1c7;font-family:Arial;font-size:12px;line-height:125%;text-align:center">
                                                    <p><a href="<?= Url::to('/', 1) ?>" target="_blank">
                                                            <span><?= Url::to('/', 1) ?></span></a></p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>