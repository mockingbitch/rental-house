var formData;


$( document ).ready(function() {
    for (let i = 0; i <= 3; i++) {
        $('.add-images_' + i).on('click', function() {
            $('#images-add_' + i).click();
        });
        $('#images-add_' + i).on('change', function (event) {
            formData.set('image_' + i, event.target.files[0]);
            let src = URL.createObjectURL(event.target.files[0]);
            // console.log(images);
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


// handle show view detail room
const handleViewDetail = (id) => {
    // get list tags
    // let api = API_GET_TAGS;
    // getData(api, {}, appendTagUpdate);

    getData(
        API_ROOM_DETAIL,
        { id: id },
        nextGetRoomDetail
    );
}

// const appendTagUpdate = (data) => {
//     let optProvince = '';
//     let optDistrict = '';
//     let optWard = '';
//     optProvince = optProvince + data.address.provinces.map(item =>
//         optProvince = `
//             <option value="${item.code}">${item.full_name}</option>
//             `
//     );
//     optDistrict = optDistrict + data.address.districts.map(item =>
//         optDistrict = `
//             <option value="${item.code}">${item.full_name}</option>
//             `
//     );
//     optWard = optWard + data.address.wards.map(item =>
//         optWard = `
//             <option value="${item.code}">${item.full_name}</option>
//             `
//     );
//     $('#province_code-update').html(optProvince);
//     $('#district_code-update').html(optDistrict);
//     $('#ward_code-update').html(optWard);
// }

const nextGetRoomDetail = (data) => {
    console.log(data);
    $('#update-form').css('display', 'block');
    let item = data.room;
    let type = 'update';
    for (let key in item) {
        if (item.hasOwnProperty(key)) {
            $(`#${key}-${type}`).val(item[key])
        }
    }

    // setting formData
    formData = new FormData($('#update-form form')[0]);
    item.images.forEach((image, index) => {
        formData.set('image_' + index, image);
    });
    for (let key in item) {
        if (item.hasOwnProperty(key)) {
            $(`#${key}-${type}`).on('change', function (event) {
                // console.log(event);
                formData.set(key, event.target.value);
            })
        }
    }
    image_elements = $('#update-form div[data-id] .card');
    // console.log(image_elements);
    image_elements.each(function (index) {
        if (item.images[index]) {
            // console.log($(this));
            $(this).css('background-repeat', 'no-repeat');
            $(this).css('border-radius', '15px');
            $(this).css('background-size', '360px 120px');
            $(this).css('background-image', 'url(' + item.images[index] + ')');
        }
    });
}


// handle close form update room
$('#update-close').on('click', function () {
    $('#update-form').css('display', 'none');
})

// ....
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
};

// handle update room
$('.room-update').on('click', function () {
    let api = API_ROOM_UPDATE;
    createOrUpdateWithFile(api, formData, nextUpdateRoom);
});
const nextUpdateRoom = (data) => {
    console.log(data);
    if (data.errCode == 0) {
        swal({title: "Successfully", text: data.message, icon: "success", button: "Close"})
    } else {
        swal({title: "Something went wrong", text: data.message, icon: "warning", button: "Close"});
        // $('#status_' + data.house.id).attr('checked', false);
    }
}

// handle update status room
const updateStatus = (id, status) => {
    createOrUpdate(API_UPDATE_STATUS, { id: id, status: status }, nextUpdateStatus)
};
const nextUpdateStatus = (data) => {
    console.log(data);
    if (data.errCode == 0) {
        swal({title: "Successfully", text: data.message, icon: "success", button: "Close"})
    } else {
        swal({title: "Something went wrong", text: data.message, icon: "warning", button: "Close"});
        // $('#status_' + data.house.id).attr('checked', false);
    }
}



