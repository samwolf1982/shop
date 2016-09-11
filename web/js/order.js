var $orderItemForm = $('#order-item-form');
var $productSelect = $('#orderitem-product_id');
var $typeSelect = $('#orderitem-type_id');
var $message = $('#message');

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
            },
            error: function() {
                $message.text('Произошла ошибка');
                setTimeout(function() {
                    $message.text('');
                }, 3000)
            }
        });
    }
});

$orderItemForm.on('beforeSubmit', function () {

    if (!$typeSelect.prop('disabled') && $typeSelect.val() == '')
        return false;

    $message.text('Подождите...');

    $.ajax({
        url: '/ajax-order/create-item',
        type: 'POST',
        data: $('#order-item-form').serialize(),
        success: function() {
            $.pjax.reload({
                container: '#pjax-container',
                timeout: 1000
            });
            $orderItemForm.data('yiiActiveForm').validated = false;
        },
        error: function() {
            $message.text('Произошла ошибка');
            setTimeout(function() {
                $message.text('');
            }, 3000);
            $orderItemForm.data('yiiActiveForm').validated = false;
        }
    });
});

$orderItemForm.on('submit', function(e) {
    e.preventDefault();
});

$(document).on('pjax:end', function() {
    $message.text('');
});