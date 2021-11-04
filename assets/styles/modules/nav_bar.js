export * from './nav_bar'

const form = document.querySelector('.nav-navbar');

window.onscroll = function(){
    var top = window.scrollY

    if (top >= 450) {
        form.classList.add('nav-navbar-active')
    } else {
        form.classList.remove('nav-navbar-active')
    }
}