require('./bootstrap');

import 'simplebar';

import Alpine from 'alpinejs';
window.alpine = Alpine;
window.alpine.start();

window.swal = require('sweetalert2');
window.modal = {
    async prompt(title, message, validator, callback, confirmText = '확인', cancelText = '취소') {
        return await window.swal.fire({
            title: title,
            input: 'text',
            inputLabel: message,
            inputValue: '',
            showCancelButton: true,
            inputValidator: validator,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText
        }).then(callback);
    },
    async alert(title, message, callback, icon = 'success', confirmText = '확인') {
        await window.swal.fire({
            icon: icon,
            title: title,
            text: message,
            confirmButtonText: confirmText
        }).then(callback);
    },
    async confirm(title, message, callback, icon = 'warning', confirmText = '확인', cancelText = '취소') {
        await window.swal.fire({
            title: title,
            text: message,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmText,
            cancelButtonText: cancelText
        }).then(callback); //(r) => {} 변수 하나 있다.
    }
}
