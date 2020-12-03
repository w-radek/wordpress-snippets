import "../scss/main.scss";
var fBlack = require('./blank.js');

function refreshScripts() {
    fBlack();
}

$(document).ready(function() {
    refreshScripts();
    
    $('body').fadeIn(800);
    
});