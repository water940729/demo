$(function(){

function loadScript(url, callback){
    var script = document.createElement("script")
    script.type = "text/javascript";
    if (script.readyState){ //IE
        script.onreadystatechange = function(){
            if (script.readyState == "loaded" || script.readyState == "complete"){
                script.onreadystatechange = null;
                callback();
            }
        };
    } else { //Others
        script.onload = function(){
            callback();
        };
    }
    script.src = url;
    document.getElementsByTagName("head")[0].appendChild(script);
}  
var DEFAULT_VERSION = "9.0";
var ua = navigator.userAgent.toLowerCase();
var isIE = ua.indexOf("msie")>-1;
var safariVersion;
if(isIE){
    var load_jquery = "__PUBLIC__/Js/collect/jquery1.8.js";
} else {
    var load_jquery = "/Public/Js/jquery/jquery.js";
}

window.onload=loadScript( load_jquery, function(){
})

})
