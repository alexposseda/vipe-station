$('#client-select-btn').on('click', function () {
    $('#client-select').removeClass('hidden');
    $('#client-select-btn').addClass('hidden');
});

$('#remove-client-select').on('click', function () {
    $('#client-select').addClass('hidden');
    $('#client-select-btn').removeClass('hidden');
});

$('#del-index').on('select', function () {
    var url = $(this).data('url');
});