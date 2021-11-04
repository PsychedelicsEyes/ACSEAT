export * from './nav_bus'



$(document).ready(function(){
    $(window).scroll(function(){
        if($(window).scrollTop() > $(window).height()){
            $(".nav-navbar").css({"background-color":"transparent"});
        }
        else{
            $(".nav-navbar").css({"background-color":"white"});
        }

    })
})










