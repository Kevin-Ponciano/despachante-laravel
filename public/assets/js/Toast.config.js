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
    timer: 10000,
    timerProgressBar: true,
    background: bgToast,
    width: 'auto',
    customClass: {
        htmlContainer: 'm-0',
        timerProgressBar: 'bg-primary',
    }
});

let success = (data) => {
    const url = data.url;
    const message = data.message;
    if (url === undefined) {
        Toast.fire({
            icon: 'success',
            html: `<div class='fw-semibold mt-2 ${titleToast}'>${message ?? data}</div>`
        })
    } else {
        Toast.fire({
            icon: 'success',
            html: `<div class='fw-semibold pb-1 ${titleToast}'>${message}</div>` +
                "<div class='text-center'><a href='" + url + "' class='btn btn-sm btn-teal'>Abrir</a></div>"
        })
    }
};

let info = (data) => {
    const message = data.message;
    Toast.fire({
        icon: 'info',
        html: `<div class='fw-semibold mt-2 ${titleToast}'>${message}</div>`
    })
}

let error = (data) => {
    Toast.fire({
        icon: 'error',
        html: `<div class='fw-semibold mt-2 ${titleToast}'>${data}</div>`
    })
}

let warning = (data) => {
    Toast.fire({
        icon: 'warning',
        html: `<div class='fw-semibold mt-2 ${titleToast}'>${data}</div>`
    })
}

Livewire.on('success', (data) => {
    success(data);
})

Livewire.on('info', (data) => {
    info(data);
});

Livewire.on('error', (data) => {
    error(data);
})

Livewire.on('warning', (data) => {
    warning(data);
})
