const configurationIziToast = {
    warning: {
        title: 'Avertissement',
        titleColor: '#b35900',
        icon: 'fa fa-exclamation-triangle',
        iconColor: '#b35900',
        theme: 'light',
        position: 'topCenter',
        transitionIn: 'fadeIn',
        timeout: 6000,
    },
    error: {
        title: 'Erreur',
        titleColor: '#b30000',
        icon: 'fa fa-exclamation-triangle',
        iconColor: '#b30000',
        backgroundColor: '#ef7c7c',
        theme: 'light',
        position: 'topCenter',
        transitionIn: 'fadeIn',
        timeout: 6000,
    },
    info: {
        title: 'Information',
        titleColor: '#006bb3',
        icon: 'fa fa-info-circle',
        iconColor: '#006bb3',
        theme: 'light',
        position: 'topCenter',
        transitionIn: 'fadeIn',
        timeout: 6000,
    },
    success: {
        title: 'Succès',
        titleColor: '#009900',
        icon: 'fa fa-check-circle',
        iconColor: '#009900',
        theme: 'light',
        position: 'topCenter',
        transitionIn: 'fadeIn',
        timeout: 5000,
    }
};

function iziToastSuccess (message, title = ""){
    toast(message, title, 'success');

}
function iziToastWarning (message, title = ""){
    toast(message, title, 'warning');
}
function iziToastInfo (message, title = ""){
    toast(message, title, 'info');
}
function iziToastError (message, title = ""){
    toast(message, title, 'error');
}

function toast(message, title, type, session = true) {
    if (session) {
        iziToast[type]({
            ...configurationIziToast[type],
            title,
            message,
            onOpening: () => {
                const toasts = JSON.parse(sessionStorage.getItem('toasts') ?? '[]');
                toasts.push({
                    title,
                    message,
                    type,
                    expiration: Date.now() + (configurationIziToast[type].timeout ?? 6000)
                });
                sessionStorage.setItem('toasts', JSON.stringify(toasts));
            },
            onClosed: () => {
                const toasts = JSON.parse(sessionStorage.getItem('toasts') ?? '[]');
                sessionStorage.setItem('toasts', JSON.stringify(toasts.filter(toast => toast.title !== title && toast.message !== message && toast.type !== type)));
            }
        });
    }
    else {
        iziToast[type]({
            ...configurationIziToast[type],
            title,
            message
        });
    }
}

jQuery(document).ready(() => {
    const toasts = JSON.parse(sessionStorage.getItem('toasts') ?? '[]');
    sessionStorage.setItem('toasts', '[]');

    toasts.forEach(toast => {

        const remainingDuration = toast.expiration - Date.now();

        if (remainingDuration > 0) {
            iziToast[toast.type]({
                ...configurationIziToast[toast.type],
                title: toast.title,
                message: toast.message,
                timeout: remainingDuration
            });
        }
    })
})