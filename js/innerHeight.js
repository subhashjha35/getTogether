/**
 * Created by subhash on 20/4/17.
 */

$(function(){
    $(window).bind("load resize",function (){
        topOffset = 50;
        if(this.window.innerWidth >= 1024) {
            height = this.window.innerHeight - topOffset;
            $("#section-1").css("min-height", height + "px");
        }else{
            $("#section-1").css("min-height", 1 + "px");
        }
    })
})