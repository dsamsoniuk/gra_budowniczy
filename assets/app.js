import './vendor/bootstrap/dist/css/bootstrap.min.css'
import './vendor/select2/dist/css/select2.min.css'
import './styles/app.css';


import './stimulus_bootstrap.js';
import $ from 'jquery';
import select2 from 'select2'
select2($)

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

$('#test1').html('witaj test1 jquery')

$('#select-test').select2()
