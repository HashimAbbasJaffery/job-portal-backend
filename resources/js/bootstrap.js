/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

import Echo from "laravel-echo"

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '4df466d966a05206294a',
    cluster: 'ap2',
    encrypted: true
});

Echo.join('chat')
.joining((user) => {
    axios.put('/api/user/'+ user.id +'/online?api_token=' + user.api_token, {});
});

Echo.join('chat')
.listen('UserOnline', (e) => {
    this.friend = e.user;
})

Echo.join('chat')
    .leaving((user) => {
    axios.put('/api/user/'+ user.id +'/offline?api_token=' + user.api_token, {});
    })

    Echo.join('chat')
    .listen('UserOffline', (e) => {
        this.friend = e.user;
    });

    alert("lol");


