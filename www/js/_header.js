/**
 * Created by gektorgit on 06.02.17.
 */
$('#cart_index').click(function(){
    var count = parseInt($('#cart-count').text());
    if(count == 0){
        Materialize.toast('Корзина пуста', 4000);
        return false;
    }
});