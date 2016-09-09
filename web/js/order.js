var $orderItemForm = $('#order-item-form');
var $productSelect = $('#orderitem-product_id');
var $typeSelect = $('#orderitem-type_id');
var $loading = $('#loading');

$productSelect.on('change', function() {

    $typeSelect.empty()
        .append("<option value=''>- Выберите тип -</option>")
        .prop("disabled", true);

    if ($(this).val() > 0) {
        $.ajax({
            url: '/ajax-order/load-types/' + $(this).val(),
            type: 'POST',
            success: function(data) {
                if ($(data).length > 0) {
                    $.each(data, function(key, value) {
                        $typeSelect.append('<option value="' + key + '">' + value + '</option>')
                    });
                    $typeSelect.prop('disabled', false);
                }
            }
        });
    }
});

$orderItemForm.on('beforeSubmit', function () {

    if (!$typeSelect.prop('disabled') && $typeSelect.val() == '')
        return false;

    $loading.show();
    $.ajax({
        url: '/ajax-order/create-item',
        type: 'POST',
        data: $('#order-item-form').serialize(),
        success: function(data) {
            $.pjax.reload({
                container: '#pjax-container',
                timeout: 1000
            });
        }
    });
});

$orderItemForm.on('submit', function(e) {
    e.preventDefault();
});

$(document).on('pjax:end', function() {
    $loading.hide();
});