$(document).ready(function () {
});


// $('.add-thumbnail').on('click', function() {
//     $('#thumbnail').click();
// });

// add event when click update image show dialog select image
$('.cover-image').on('click', function () {
    $('#avatar-update').click();
})


// $('#thumbnail').on('change', function (event) {
//     let src = URL.createObjectURL(event.target.files[0]);
//     $('.add-thumbnail').css('background-repeat', 'no-repeat');
//     $('.add-thumbnail').css('border-radius', '15px');
//     $('.add-thumbnail').css('background-size', '360px 120px');
//     $('.add-thumbnail').css('background-image', 'url(' + src + ')');
// });

// add event when chane image show new image
$('#avatar-update').on('change', function (event) {
    let src = URL.createObjectURL(event.target.files[0]);
    $('.cover-image').css('background-repeat', 'no-repeat');
    $('.cover-image').css('border-radius', '15px');
    $('.cover-image').css('background-size', 'cover');
    $('.cover-image').css('background-image', 'url(' + src + ')');
});
// $('.cancel-btn').on('click', function () {
//     var x = document.getElementById("create-form");
//     x.style.display = "none";
// });

// add event close update form wwhen click button cancel
$('.cancel-update-btn').on('click', function() {
    var x = document.getElementById("update-form");
    x.style.display = "none";
    scrollToTop();
});
// $('.house-update').on('click', function () {
//     let api = API_HOUSE_UPDATE;
//     let data = {
//         id: $('#house-id').val(),
//         name: $('#name-update').val() ?? '',
//         description: $('#description-update').val() ?? '',
//         province_code: $('#province_code-update').val() ?? '',
//         district_code: $('#district_code-update').val() ?? '',
//         ward_code: $('#ward_code-update').val() ?? '',
//         address: $('#address-update').val() ?? '',
//         category_id: $('#category-update').val() ?? '',
//         // thumbnail: $('#thumbnail-update').prop('files')[0] ?? '',
//         type: 'update'
//     };
//     createOrUpdate(api, data, nextUpdateHouse);
// });

const toggleUpdateForm = () => {
    var x = document.getElementById("update-form");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

// update satus
const updateStatus = (id, status) => {
    createOrUpdate(API_USER_UPDATE, { id: id, status: status == '1' ? '0' : '1' }, nextUpdateStatus)
}
const nextUpdateStatus = (data) => {
    if (data.errCode == 0) {
        getData(API_USERS_INDEX, {}, updateUserTable);
        swal({title: "Successfully", text: data.message, icon: "success", button: "Close"})
    } else {
        swal({title: "Something went wrong", text: data.message, icon: "warning", button: "Close"});
        $('#status_' + data.house.id).attr('checked', false);
    }
}

// add data to modal when click view user detail
const handleViewDetail = (user) => {
    $('#modal-img').attr('src', user.avatar);
    $('#modal-name').text(user.first_name + ' ' + user.last_name)
    $('#modal-email').text(user.email)
    $('#modal-region').text(user.region)
    $('#modal-ward').text(user.ward_name)
    $('#modal-birthday').text(user.birthday)
    if (user.status == 1) {
        $('#modal-status').text("Active")
        $('#modal-status').addClass("bg-gradient-success")
    } else {
        $('#modal-status').text("Inactive")
        $('#modal-status').addClass("bg-gradient-dark")

    }
    $('#modal-description').text(user.description)
}

// add data to form when click edit user
const handleEditForm = (user) => {
    toggleUpdateForm();
    $('#user-id').val(user.id);
    $('#first-name-update').val(user.first_name);
    $('#last-name-update').val(user.last_name);
    $('#email-update').val(user.email);
    $('#birthday-update').val(user.birthday);
    $('#region-update').val(user.region);
    $('#description-update').val(user.description);
    
    $('#ward-update option')
        .removeAttr('selected')
        .filter(function (index) {
            if (this.value == user.ward_code) {
                console.log(this.value);
                this.selected = true;
            }
        });
    $('#role-update option')
        .removeAttr('selected')
        .filter(function (index) {
            console.log(this.value);
            if (this.value == user.role) {
                this.selected = true;
            }
        });
    $('#status-update option')
        .removeAttr('selected')
        .filter(function (index) {
            if (this.value == user.status) {
                console.log(this.value);
                this.selected = true;
            }
        });

    $('.cover-image').css('background-repeat', 'no-repeat');
    $('.cover-image').css('border-radius', '15px');
    $('.cover-image').css('background-size', 'cover');
    $('.cover-image').css('background-position', '0% 0%');
    $('.cover-image').css('background-image', 'url(' + user.avatar + ')');
}

// const handleViewDetail1 = (id) => {
//     let api = API_GET_ADDRESS;
//     let dataSearch = {
//         province: '',
//         district: '',
//         ward: ''
//     };
//     getData(api, dataSearch, appendAddressUpdate);
//     getData(
//         API_HOUSE_DETAIL,
//         { id: id },
//         nextGetHouseDetail
//     );
// }

// const nextGetHouseDetail = (data) => {
//     $('#update-form').css('display', 'block');
//     let item = data.house;
//     let type = 'update';
//     for (let key in item) {
//         if (item.hasOwnProperty(key) && key !== 'thumbnail') {
//             $(`#${key}-${type}`).val(item[key])
//         }
//     }
//     $('#house-id').val(item.id);
//     $(`#province_code-update option[value=${item.province_code}]`).attr('selected','selected');
//     $(`#district_code-update option[value=${item.district_code}]`).attr('selected','selected');
//     $(`#ward_code-update option[value=${item.ward_code}]`).attr('selected','selected');
//     $(`#category-update option[value=${item.category_id}]`).attr('selected','selected');
//     $('.update-thumbnail').css('background-repeat', 'no-repeat');
//     $('.update-thumbnail').css('border-radius', '15px');
//     $('.update-thumbnail').css('background-size', '360px 120px');
//     $('.update-thumbnail').css('background-image', 'url(' + item.thumbnail + ')');
// }

// const appendAddressUpdate = (data) => {
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

// const nextUpdateHouse = (data) => {
//     console.log(data);
// }

// handle update user
$('.user-update').on('click', function () {
    let api = API_USER_UPDATE;
    let formData = new FormData($('#update-form form')[0]);
    createOrUpdateWithFile(api, formData, nextUpdateUser);
});
const nextUpdateUser = (data) => {
    console.log(data);
    if (data.errCode == 0) {
        toggleUpdateForm();
        getData(API_USERS_INDEX, {}, updateUserTable);
        swal({title: "Successfully", text: data.message, icon: "success", button: "Close"})
        scrollToTop();
    } else {
        swal({title: "Error", text: data.message, icon: "warning", button: "Close"});
        // $('#status_' + data.house.id).attr('checked', false);
    }
}
const updateUserTable = (page) => {
    $('#user-table').replaceWith($(page).find('#user-table'));
}