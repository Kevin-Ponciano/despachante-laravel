const imaskConfigTel = {
    mask: [
        {
            mask: '(00) 0000-0000',
            maxLength: 14 // Define o limite máximo de caracteres para telefones fixos
        },
        {
            mask: '(00) 00000-0000',
            maxLength: 15 // Define o limite máximo de caracteres para celulares
        }
    ]
};

const imaskConfigCpfCnpj = {
    mask: [
        {
            mask: '000.000.000-00',
            maxLength: 14
        },
        {
            mask: '00.000.000/0000-00',
            maxLength: 18
        }
    ]
}
let elTelProcesso = $('#telefone-p')[0]
IMask(elTelProcesso, imaskConfigTel)

let imask_preco = () => {
    $('.imask-preco').each(function () {
        let el = this;
        IMask(el, {
            mask: Number,  // enable number mask

            // other options are optional with defaults below
            scale: 2,  // digits after point, 0 for integers
            padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
            normalizeZeros: true,  // appends or removes zeros at ends
            radix: '.',  // fractional delimiter
            mapToRadix: [','],  // symbols to process as radix

            // additional number interval options (e.g.)
        })
    })
}
imask_preco();
$(window).on('servico-added', function(event) {
    imask_preco();
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
