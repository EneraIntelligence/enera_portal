$(document).ready(function() {
    window.addEventListener("orientationchange", function() {
        // Announce the new orientation number
        if(window.orientation == 90){
            alert('portrait mode');
        }
        else
        {
            alert('landscape mode ');
        }
    }, false);
})