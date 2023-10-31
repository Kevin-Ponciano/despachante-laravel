$(document).ready(function () {
    function setMinutes(minutes) {
        return minutes * 60 * 1000;
    }

    const timeRefreshDashboard = setMinutes(5);
    let countdownTime = timeRefreshDashboard;
    if (localStorage.getItem('autoUpdateEnabled') === null) {
        localStorage.setItem('autoUpdateEnabled', 'true');
    } else if (localStorage.getItem('autoUpdateEnabled') === 'true') {
        $('#on-update-dashboard').addClass('text-success').removeClass('text-danger');
    } else {
        $('#on-update-dashboard').addClass('text-danger').removeClass('text-success');
    }

    function atualizarDashboard() {
        $('#loading-overlay').show();
        window.livewire.emit('atualizarDashboard');
    }

    window.livewire.on('atualizarDashboardDone', () => {
        $('#loading-overlay').hide();
        resetCountdown();
    });

    function resetCountdown() {
        countdownTime = timeRefreshDashboard; // Resetar o contador
    }


    function checkAndUpdateDashboard() {
        if (localStorage.getItem('autoUpdateEnabled') === 'true') {
            atualizarDashboard();
        }
    }

    function updateCountdownDisplay() {
        let minutes = Math.floor(countdownTime / 60000);
        let seconds = Math.floor((countdownTime % 60000) / 1000);
        $('#countdown-timer').text(`${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);

        if (localStorage.getItem('autoUpdateEnabled') === 'true') {
            countdownTime -= 1000;
        }

        if (countdownTime <= -1) {
            checkAndUpdateDashboard();
        }
    }

    $('#on-update-dashboard').on('click', function () {
        const currentValue = localStorage.getItem('autoUpdateEnabled') === 'true';
        const newValue = !currentValue;
        localStorage.setItem('autoUpdateEnabled', newValue.toString());
        if (!newValue) {
            resetCountdown(); // Resetar o contador quando desativar a atualização automática
            $(this).addClass('text-danger').removeClass('text-success');
        } else {
            $(this).removeClass('text-danger').addClass('text-success');
        }
    });

    setInterval(updateCountdownDisplay, 1000); // Atualizar o contador a cada segundo
    //setInterval(checkAndUpdateDashboard, timeRefreshDashboard); // Atualizar o dashboard a cada 5 minutos
});
