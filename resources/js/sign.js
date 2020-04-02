$(document).ready(function() {
    $("#signature").jSignature()
});
function signature(){
    var $sigdiv = $("#signature");
    var datax = $sigdiv.jSignature("getData","svg"); // for embedding is html page
    $('#sign').val(datax);
    var datax = $sigdiv.jSignature("getData","base30"); // for creating image
    $('#img').val(datax);
    $sigdiv.jSignature("reset");
    $('#f').submit();
}