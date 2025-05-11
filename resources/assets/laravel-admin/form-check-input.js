export function form_check_input() {
    $(".form-switch .form-check-input").change(function () {
        var key = $(this).data('key');
        var name = $(this).data('name');
        var resource = $(this).data('resource');

        if ($(this).prop("checked")) {
            var value = $(this).data('on');
        } else {
            var value = $(this).data('off');
        }
        var _status = true;

        $.ajax({
            url: resource + "/" + key,
            type: "POST",
            async: false,
            data: {
                [name]: value,
                _token: LA.token,
                _method: 'PUT',
                _edit_inline: true
            },
            success: function (data) {
                if (data.status)
                    toastr.success(data.message);
                else
                    toastr.warning(data.message);
            },
            error: function (xhr, textStatus, errorThrown) {
                _status = false;
                var data = xhr.responseJSON
                if (data['errors'] || data['message']) {
                    var message = data['message'] || Object.values(data['errors']).join("\n");
                    toastr.error(message);
                } else {
                    toastr.error('Error: ' + errorThrown);
                }
            },
            complete: function (xhr, status) {
                if (status == 'success')
                    _status = xhr.responseJSON.status;
            }
        });
    });
}