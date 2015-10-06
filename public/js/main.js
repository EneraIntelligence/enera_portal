$(document).ready(function() {
    window.addEventListener("orientationchange", function() {
        // Announce the new orientation number
        if(window.orientation == 0){
            document.getElementById("modal1").style.opacity = 0;
        }
        else if (window.orientation == 90)
        {
            document.getElementById("modal1").style.opacity = 1;
        }
    }, false);
})