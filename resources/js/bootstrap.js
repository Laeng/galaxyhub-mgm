import {Chart} from "chart.js";

window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

window.toastify = require('./toastify.js');

window.toast = {
    show: (type, message, duration = 3000, position = 'center', gravity = 'bottom') => {
        new window.toastify.lib.init({
            text: message,
            className: type,
            position: position,
            gravity: gravity,
            duration: duration,
        }).showToast();
    },
    error: (message, duration = -1, position = 'center', gravity = 'bottom') => {
        window.toast.show('error', message, duration, position, gravity);
    },
    success: (message, duration = 3000, position = 'center', gravity = 'bottom') => {
        window.toast.show('success', message, duration, position, gravity);
    },
}

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

// window.ckeditor = require('@ckeditor/ckeditor5-build-classic')

window.global = {}
