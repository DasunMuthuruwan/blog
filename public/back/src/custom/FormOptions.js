FormOptions = {
    submitForm: function (form_id, clear_form = true, trigger_change = []) {
        form_id = '#' + form_id;
        let isValid = $(form_id).valid();

        if (isValid) {
            let url = $(form_id).attr('action');
            let method = $(form_id).attr('method');
            $(form_id).ajaxSubmit(
                {
                    clearForm: clear_form,
                    url: url,
                    type: method,
                    success: function (result) {
                        if (result.success) {
                            (result.warning) ? Notifications.showWarningMsg(result.message) : Notifications.showSuccessMsg(result.message);
                        } else {
                            $(form_id)[0].reset();
                            Notifications.showErrorMsg(result.message);
                        }
                        $.each(trigger_change, function (key, value) {
                            $(value).trigger('change');
                        });
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        if (XMLHttpRequest.status !== 422) {
                            Notifications.showErrorMsg(errorThrown);
                        }
                    }
                }
            );
        }
    },
    deleteRecord: function (record_id, url, table, text = "You won't be able to revert this!", title = "Are you sure?", icon = "warning", confirmButtonText = "Yes, delete it!", successMessage = "Your record has been deleted.") {
        let tableName = '#' + table;
        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: url,
                    type: 'delete',
                    data: {
                        id: record_id,
                    },
                    success: function (result) {
                        if (result.success) {
                            let table = $(tableName).DataTable();
                            table.ajax.reload();
                            Swal.fire(
                                'Deleted!',
                                successMessage,
                                'success'
                            );
                        } else {
                            let msg = result.message;
                            Notifications.showErrorMsg(msg);
                        }
                    }
                });
            }
        });
    },
    initValidation: function (form_id, rules = [], select2 = 'select2') {
        let form_name = '#' + form_id;
        console.log('sss');

        $(form_name).validate({
            errorPlacement: function (error, element) {
                if (element.is('select') && element.hasClass(select2)) {
                    error.insertAfter(element.next());
                    element.next().addClass('error-element');
                } else {
                    error.insertAfter(element);
                    element.addClass('error-element');
                }
            },
            success: function (error, element) {
                error.remove();
                element.classList.remove('error-element');
            },
            rules: rules
        });
    },
};
