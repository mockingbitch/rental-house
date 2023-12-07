$( document ).ready(function() {
    for (let i = 0; i <= 3; i++) {
        $('.add-images_' + i).on('click', function() {
            $('#images-add_' + i).click();
        });
        $('#images-add_' + i).on('change', function (event) {
            let src = URL.createObjectURL(event.target.files[0]);
            $('.cover-image_' + i).css('background-repeat', 'no-repeat');
            $('.cover-image_' + i).css('border-radius', '15px');
            $('.cover-image_' + i).css('background-size', '100% 100%');
            $('.cover-image_' + i).css('background-position', '0% 0%');
            $('.cover-image_' + i).css('background-image', 'url(' + src + ')');
        });
    }
});
const create = () => {
    var x = document.getElementById("create-form");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
$('.update-thumbnail').on('click', function () {
    $('#thumbnail-update').click();
})
$('#thumbnail').on('change', function (event) {
    let src = URL.createObjectURL(event.target.files[0]);
    $('.add-thumbnail').css('background-repeat', 'no-repeat');
    $('.add-thumbnail').css('border-radius', '15px');
    $('.add-thumbnail').css('background-size', '360px 120px');
    $('.add-thumbnail').css('background-image', 'url(' + src + ')');
});

const appendNewImageElement = (elementCounter) => {
    console.log(elementCounter)
    $('.images-element').append(`
        <input type="file" name="images[]" id="images-add_${elementCounter}" hidden accept="image/*" />
        <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
            <div class="card h-100 card-plain border">
                <div class="card-body d-flex flex-column justify-content-center text-center add-images_${elementCounter}">
                    <i class="fa fa-plus text-secondary mb-3"></i>
                    <h5 class="text-secondary"> Images </h5>
                </div>
            </div>
        </div>
    `);
}
