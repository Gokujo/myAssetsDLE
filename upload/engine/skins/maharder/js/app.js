$('#box-navi .item').tab();
$('.ui.checkbox').checkbox();
$('.dropdown').dropdown();
$(document).on('click', '.checkbox', function() {
    console.log($(this).find('.hidden').first().prop('checked', true))
    $(this).find('.hidden').first().attr('checked');
});
$('.chosen').tokenfield();