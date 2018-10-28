$('#box-navi .item').tab();
$('.ui.checkbox').checkbox();
$('.dropdown').dropdown();
$('.no.label.ui.dropdown').dropdown({
    useLabels: false
});
var stickys = $(document).find('.sticky');
if(stickys > 0) {
    $('.sticky').sticky({
        context: '.docContent',
        pushing: true
    });
}
$('.docMenu .item').tab();
$('.chosen').tokenfield();

function startLoading() {
    $('.loader').delay(50).fadeIn();
}
function hideLoading() {
    $('.loader').delay(500).fadeOut();
}