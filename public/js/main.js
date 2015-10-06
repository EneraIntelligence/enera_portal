$(document).ready(function() {
    window.addEventListener("orientationchange", function() {
        // Announce the new orientation number
        if(window.orientation == 0){
            alert('portrait mode');
        }
        else if (window.orientation == 90)
        {
            alert('landscape mode ');
        }
    }, false);
})