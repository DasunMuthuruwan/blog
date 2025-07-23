FormOptions = {
    submitForm: function (form_id, clear_form = true) {
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
                        $(form_id)[0].reset();
                        Notifications.showSuccessMsg(result.message);
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        if (XMLHttpRequest.status === 422) {
                            $.each(XMLHttpRequest.responseJSON.errors, function (key, error) {
                                Notifications.showErrorMsg(error);
                            });
                        } else {
                            Notifications.showErrorMsg(errorThrown);
                        }
                    }
                }
            );
        }
    },
    deleteRecord: function (id, action, text = "You won't be able to revert this!", title = "Are you sure?", icon = "warning", confirmButtonText = "Yes, delete it!", successMessage = "Your record has been deleted.") {
        Swal.fire({
            title: title,
            text: text,
            icon: "info",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText,
            fontSize: "0.87rem"
        }).then((result) => {
            if (result.value) {
                Livewire.dispatch(`${action}`, [id])
            }
        });
    },
    initValidation: function (form_id, rules = [], select2 = 'select2') {
        let form_name = '#' + form_id;
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
