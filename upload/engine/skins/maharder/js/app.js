$('#box-navi .item').tab();
$('.ui.checkbox').checkbox();
$('.dropdown').dropdown();
$('.no.label.ui.dropdown').dropdown({
    useLabels: false
});
var stickys = $(document).find('.sticky');
if (stickys > 0) {
    $('.sticky').sticky({
        context: '.docContent',
        pushing: true
    });
}
$('.docMenu .item').tab();
$('.chosen').tokenfield();

function startLoading() {
    $('.ui.dimmer').addClass('active');
}

function hideLoading() {
    $('.ui.dimmer').removeClass('active');
}
autosize(document.querySelectorAll('textarea'));