function showLoading() {
    $('#btn-page-block-spinner').click();
}

function hideLoading() {
    $('#remove-page-btn').click();
}
$('.submit-btn, .save-btn').on('click', function() {
    showLoading();
});
