// ------------------ Alpine Mask ------------------
const alpineMaskNumero = () => {
    return '9999999999999999999999'
}
const alpineMaskNumero11 = () => {
    return '99999999999'
}
const alpineMaskNumero12 = () => {
    return '999999999999'
}
const alpineMaskCep = () => {
    return '99999-999'
}
const alpineMaskUf = () => {
    return 'aa'
}

//------------------ IMask ------------------

const imaskConfig = {
    telefone: [
        {
            mask: '(00) 0000-0000',
            maxLength: 14 // Define o limite máximo de caracteres para telefones fixos
        },
        {
            mask: '(00) 00000-0000',
            maxLength: 15 // Define o limite máximo de caracteres para celulares
        }
    ],
    cpfCnpj: [
        {
            mask: '000.000.000-00',
            maxLength: 14
        },
        {
            mask: '00.000.000/0000-00',
            maxLength: 18
        }
    ],
    preco: {
        mask: Number,  // enable number mask
        scale: 2,  // digits after point, 0 for integers
        padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
        normalizeZeros: true,  // appends or removes zeros at ends
        radix: '.',  // fractional delimiter
        mapToRadix: [',']  // symbols to process as radix
    }
};

function applyIMask(selector, config) {
    $(selector).each(function () {
        let el = this;
        IMask(el, config);
    });
}

function applyIMasks() {
    applyIMask('.imask-telefone', imaskConfig.telefone);
    applyIMask('.imask-cpf-cnpj', imaskConfig.cpfCnpj);
    applyIMask('.imask-preco', imaskConfig.preco);
}

applyIMasks();

$(window).on('servico-added', function (event) {
    applyIMasks();
});


// let numberMask = (el) => {
//     let number = IMask(el, {
//         mask: Number,  // enable number mask
//
//         // other options are optional with defaults below
//         scale: 2,  // digits after point, 0 for integers
//         thousandsSeparator: '.',  // any single char
//         padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
//         normalizeZeros: true,  // appends or removes zeros at ends
//         radix: ',',  // fractional delimiter
//         mapToRadix: ['.'],  // symbols to process as radix
//
//         // additional number interval options (e.g.)
//     })
// }

// $('.imask-real').each(function () {
//     numberMask(this);
// });
// let el = $('.imask-real')[0];
// let number = IMask(el, {
//     mask: Number,  // enable number mask
//
//     // other options are optional with defaults below
//     scale: 2,  // digits after point, 0 for integers
//     thousandsSeparator: '.',  // any single char
//     padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
//     normalizeZeros: true,  // appends or removes zeros at ends
//     radix: ',',  // fractional delimiter
//     mapToRadix: ['.'],  // symbols to process as radix
//
//     // additional number interval options (e.g.)
// })
//
// let log = () => {
//     console.log(number.unmaskedValue)
// }
