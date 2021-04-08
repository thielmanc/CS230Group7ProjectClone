/*
Keeps the header stickied to the top of the page
*/ 

window.onscroll = function() {headerFunction()};
var header = document.getElementById("navbar navbar-expand-lg navbar-dark bg-dark");
var sticky = header.offsetTop;

function headerFunction() {
    if (window.pageYOffset > sticky) {
        headerFunction.classList.add("sticky");
    } else {
        headerFunction.classList.remove("sticky");
    }

}