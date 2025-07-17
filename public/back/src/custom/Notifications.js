Notifications = {
    showSuccessMsg(msg) {
        $.toast({
            heading: 'Well done!',
            text: msg,
            position: 'bottom-right',
            loaderBg: '#0EA5E9',
            hideAfter: 3500,
            stack: 6,
            showHideTransition: 'fade',
            icon: 'info', // success | info | warning | error
        });
    },
    showErrorMsg(msg) {
        $.toast({
            heading: 'Oh snap!',
            text: msg,
            position: 'bottom-right',
            loaderBg: '#7a5449',
            class: 'jq-toast-danger',
            icon: 'error',
            hideAfter: 3500,
            stack: 6,
            showHideTransition: 'fade'
        });
    },
    showWarningMsg(msg) {
        $.toast({
            heading: 'Oh snap!',
            text: msg,
            position: 'bottom-right',
            loaderBg: '#8c7b41',
            class: 'warning',
            hideAfter: 3500,
            stack: 6,
            showHideTransition: 'fade'
        });
    },
};
