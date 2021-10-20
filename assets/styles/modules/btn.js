export * from './btn'

const menuBtn_burger = document.getElementById('burger_menu_responsive');
const menuBtn = document.querySelector('.menu-btn');
let menuOpen = false;


menuBtn.addEventListener('click', () => {
     if(!menuOpen){
     menuBtn.classList.toggle('open');
     menuBtn_burger.style.display= "block"
     menuOpen = true;
}else {
          menuBtn.classList.remove('open');
          menuBtn_burger.style.display= "none"
          menuOpen = false;
     }
});