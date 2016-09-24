$(document).ready(function(){
    

    $("a[target]").click(function() {
        var target=$(this).attr('target');
        var tarObj=document.getElementById(target);
        if(tarObj===null)
            return false;
        if(tarObj.style.display=='none'){
            tarObj.style.display='block';
        }else{
            tarObj.style.display='none';
        }
        return false;
    });

    //mobile menu toggling
    $("#menu_icon").click(function(){
        $("header nav ul").toggleClass("show_menu");
        $("#menu_icon").toggleClass("close_menu");
        return false;
    });

    

    //Contact Page Map Centering
    var hw = $('header').width() + 50;
    var mw = $('#map').width();
    var smw = $('#small-map').width();
    var wh = $(window).height();
    var ww = $(window).width();

var sMapElem = document.getElementById('small-map');
var mapElem = document.getElementById('map');


    if (!(sMapElem === null)) {
        $('#small-map').css({
        "max-width" : smw,
        "height" : wh-450 
    });
    }

    if(!(mapElem === null)){
        $('#map').css({
                "max-width" : mw,
                "height" : wh 
            });
        if(ww>1100){
         $('#map').css({
            "margin-left" : hw
        });
    }
    }

    


    

    

   



    // //Tooltip
    // $("a").mouseover(function(){

    //     var attr_title = $(this).attr("data-title");

    //     if( attr_title == undefined || attr_title == "") return false;
        
    //     $(this).after('<span class="tooltip"></span>');

    //     var tooltip = $(".tooltip");
    //     tooltip.append($(this).data('title'));

         
    //     var tipwidth = tooltip.outerWidth();
    //     var a_width = $(this).width();
    //     var a_hegiht = $(this).height() + 3 + 4;

    //     //if the tooltip width is smaller than the a/link/parent width
    //     if(tipwidth < a_width){
    //         tipwidth = a_width;
    //         $('.tooltip').outerWidth(tipwidth);
    //     }

    //     var tipwidth = '-' + (tipwidth - a_width)/2;
    //     $('.tooltip').css({
    //         'left' : tipwidth + 'px',
    //         'bottom' : a_hegiht + 'px'
    //     }).stop().animate({
    //         opacity : 1
    //     }, 200);
       

    // });

    // $("a").mouseout(function(){
    //     var tooltip = $(".tooltip");       
    //     tooltip.remove();
    // });


});





