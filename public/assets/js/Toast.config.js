$(document).ready(function () {
    const theme = localStorage.getItem('theme');
    let bgToast = '#eef1f4';
    let titleToast = '';

    if (theme === 'dark') {
        bgToast = '#182433';
        titleToast = 'text-white';
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 5000,
        timerProgressBar: true,
        background: bgToast,
        width: 'auto',
        customClass: {
            htmlContainer: 'm-0',
            timerProgressBar: 'bg-primary',
        }
    });

    Livewire.on('success', (data) => {
        const url = data.url;
        const message = data.message;
        if (url === undefined) {
            Toast.fire({
                icon: 'success',
                html: `<div class='fw-semibold mt-2 ${titleToast}'>${message}</div>`
            })
        } else {
            Toast.fire({
                icon: 'success',
                html: `<div class='fw-semibold pb-1 ${titleToast}'>${message}</div>` +
                    "<div class='text-center'><a href='" + url + "' class='btn btn-sm btn-teal'>Abrir</a></div>"
            })
        }
    })
});
