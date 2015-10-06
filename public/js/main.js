$(document).ready(function() {
    window.addEventListener("orientationchange", function() {
        // Announce the new orientation number
        alert(window.orientation);
    }, false);
})