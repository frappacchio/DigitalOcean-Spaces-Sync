var $ = jQuery;

$(document).ready(function () {
    var data = {
        dos_key: $('input[name=dos_key]').val(),
        dos_secret: $('input[name=dos_secret]').val(),
        dos_endpoint: $('input[name=dos_endpoint]').val(),
        dos_container: $('input[name=dos_container]').val(),
        action: 'dos_test_connection'
    };
    $('[name="dos_test"]').on('click', function () {
        jQuery.ajax({
            type: 'POST',
            url: DOSUtils.url,
            data: data
        }).done(function (res) {
            alert(DOSUtils.response[res.success]);
        })
    })
});