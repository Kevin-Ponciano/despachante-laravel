$(document).ready(function () {
    $(window).on('deleteFile', function (e, data) {
        $('#file-name-delete').text(data.nome);
        $('#modal-delete-file').modal('show');
        $(window).on('deleteFileConfirm', function () {
            $('#modal-delete-file').modal('hide');
            Livewire.emit('deleteFile', data.path);
        });
        $(window).on('hide.bs.modal', function () {
            $(window).off('deleteFileConfirm');
        });
    })
});
