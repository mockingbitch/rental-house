$(document).ready(function () {
});
$('.add-thumbnail').on('click', function() {
    $('#thumbnail').click();
});
$('#thumbnail').on('change', function (event) {
    let src = URL.createObjectURL(event.target.files[0]);
    $('.add-thumbnail').css('background-repeat', 'no-repeat');
    $('.add-thumbnail').css('border-radius', '15px');
    $('.add-thumbnail').css('background-size', '360px 120px');
    $('.add-thumbnail').css('background-image', 'url(' + src + ')');
});
$('.cancel-btn').on('click', function () {
    var x = document.getElementById("create-form");
    x.style.display = "none";
});
$('.cancel-update-btn').on('click', function() {
    var x = document.getElementById("update-form");
    x.style.display = "none";
    scrollToTop();
});
$('.house-update').on('click', function () {
    let api = API_HOUSE_UPDATE;
    let data = {
        name: $('#name-update').val() ?? '',
        description: $('#description-update').val() ?? '',
        province_code: $('#province_code-update').val() ?? '',
        district_code: $('#district_code-update').val() ?? '',
        ward_code: $('#ward_code-update').val() ?? '',
        address: $('#address-update').val() ?? '',
        category_id: $('#category-update').val() ?? '',
        thumbnail: $('#thumbnail-update').val() ?? '',
    };
    createOrUpdate(api, data, nextUpdateHouse);
});

const create = () => {
    var x = document.getElementById("create-form");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

const updateStatus = (id, status) => {
    createOrUpdate(API_UPDATE_STATUS, { id: id, status: status }, nextUpdateStatus)
}

const nextUpdateStatus = (data) => {
    if (data.errCode == 0) {
        swal({title: "Successfully", text: data.message, icon: "success", button: "Close"})
    } else {
        swal({title: "Something went wrong", text: data.message, icon: "warning", button: "Close"});
        $('#status_' + data.house.id).attr('checked', false);
    }
}

const handleViewDetail = (id) => {
    let api = API_GET_ADDRESS;
    let dataSearch = {
        province: '',
        district: '',
        ward: ''
    };
    getData(api, dataSearch, appendAddressUpdate);
    getData(
        API_HOUSE_DETAIL,
        { id: id },
        nextGetHouseDetail
        );
}

const nextGetHouseDetail = (data) => {
    $('#update-form').css('display', 'block');
    let item = data.house;
    let type = 'update';
    for (let key in item) {
        if (item.hasOwnProperty(key) && key !== 'thumbnail') {
            $(`#${key}-${type}`).val(item[key])
        }
    }
    console.log(item);
    $(`#province_code-update option[value=${item.province_code}]`).attr('selected','selected');
    $(`#district_code-update option[value=${item.district_code}]`).attr('selected','selected');
    $(`#ward_code-update option[value=${item.ward_code}]`).attr('selected','selected');
    $(`#category-update option[value=${item.category_id}]`).attr('selected','selected');
    $('.update-thumbnail').css('background-repeat', 'no-repeat');
    $('.update-thumbnail').css('border-radius', '15px');
    $('.update-thumbnail').css('background-size', '360px 120px');
    $('.update-thumbnail').css('background-image', 'url(' + item.thumbnail + ')');
}

const appendAddressUpdate = (data) => {
    let optProvince = '';
    let optDistrict = '';
    let optWard = '';
    optProvince = optProvince + data.address.provinces.map(item =>
        optProvince = `
            <option value="${item.code}">${item.full_name}</option>
            `
    );
    optDistrict = optDistrict + data.address.districts.map(item =>
        optDistrict = `
            <option value="${item.code}">${item.full_name}</option>
            `
    );
    optWard = optWard + data.address.wards.map(item =>
        optWard = `
            <option value="${item.code}">${item.full_name}</option>
            `
    );
    $('#province_code-update').html(optProvince);
    $('#district_code-update').html(optDistrict);
    $('#ward_code-update').html(optWard);
}

const nextUpdateHouse = (data) => {

}
