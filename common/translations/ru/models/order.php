<?php
    use common\models\OrderModel;

    return [
        OrderModel::ORDER_STATUS_ABORTED   => 'отменен',
        OrderModel::ORDER_STATUS_ACTIVE    => 'активный',
        OrderModel::ORDER_STATUS_CONFIRMED => 'подтвержден',
        OrderModel::ORDER_STATUS_DELETED   => 'удален',
        OrderModel::ORDER_STATUS_FINISHED  => 'выполнен',
        OrderModel::ORDER_STATUS_PAID      => 'оплачен',
        OrderModel::ORDER_STATUS_SENT      => 'отправлен',

        'Cart is empty' => 'Корзина пуста',
        'Price'         => 'Цена',
        'Free delivery' => 'доставка бесплатная',
        'Total Cost'    => 'Сумма'
    ];