 // js/Bootstrap FILE
import './bootstrap';

import jquery from 'jquery';

 // popover support for Bootstrap
import * as popper from '@popperjs/core';
window.Popper = popper;

 // Bootstrap JS Library 
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;
 
// chart.js
import Chart from 'chart.js/auto';
window.Chart = Chart;

//select2
import select2 from 'select2';
select2($);

//quill
import Quill from 'quill';
window.Quill = Quill;

// datatables
import DataTable from 'datatables.net-bs5';
window.DataTable = DataTable;
import 'datatables.net-fixedheader-bs5';
import 'datatables.net-responsive-bs5';
import JSZip from 'jszip'; 
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-buttons/js/buttons.print.mjs';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
 
DataTable.Buttons.jszip(JSZip);


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
