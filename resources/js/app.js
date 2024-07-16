 // js/Bootstrap file
import './bootstrap';

 // Bootstrap Library
import 'bootstrap';

 // popover support for Bootstrap
import '@popperjs/core';

// chart.js
import 'chart.js';

// datatables
import 'datatables';

//swiper
import Swiper from 'swiper';
window.Swiper = Swiper;

//vite static asset processing
import.meta.glob([
  '../images/**',
]);

//gumshoe
const gumshoe = import ('gumshoejs/dist/gumshoe.min.js');
window.gumshoe = gumshoe;

//tinyslider
import { tns } from 'tiny-slider/src/tiny-slider'; 
window.tns = tns;


//parallax
const parallax = import ('jquery-parallax.js');
window.parallax = parallax;

//waypoint
const waypoint = import ('waypoints/lib/jquery.waypoints.min.js');
window.Waypoint = waypoint;

//animatedheadline
const animatedHeadline = import ('jquery-animated-headlines');
window.animatedHeadline = animatedHeadline;
