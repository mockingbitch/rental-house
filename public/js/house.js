$('.add-thumbnail').on('click', function() {
    $('#thumbnail').click();
});
$('#thumbnail').on('change', function(event) {
    let src = URL.createObjectURL(event.target.files[0]);
    $('.add-thumbnail').css('background-repeat', 'no-repeat');
    $('.add-thumbnail').css('border-radius', '15px');
    $('.add-thumbnail').css('background-size', '360px 120px');
    $('.add-thumbnail').css('background-image', 'url(' + src + ')');
});