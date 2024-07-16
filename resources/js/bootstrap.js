
import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import jquery from 'jquery';
window.$ = window.jQuery = jquery;

import DocReady from 'es6-docready';
window.DocReady = DocReady;

