$(document).ready(function () {
    getAddress();
});
$('#province_code-add').on('change', () => {
    $('#ward_code-add').html('');
    getData(
        API_GET_ADDRESS,
        { province: $('#province_code-add').val() },
        nextSelectProvince
        );
});
$('#district_code-add').on('change', () => {
    getData(
        API_GET_ADDRESS,
        { district: $('#district_code-add').val() },
        nextSelectDistrict
        );
});
$('#province_code-update').on('change', () => {
    $('#ward_code-update').html('');
    getData(
        API_GET_ADDRESS,
        { province: $('#province_code-update').val() },
        nextSelectProvince
    );
});
$('#district_code-update').on('change', () => {
    getData(
        API_GET_ADDRESS,
        { district: $('#district_code-update').val() },
        nextSelectDistrict
    );
});

const getAddress = (
    province = '',
    district = '',
    ward = ''
    ) => {
    let api = API_GET_ADDRESS;
    let dataSearch = {
        province: province,
        district: district,
        ward: ward
    };
    getData(api, dataSearch, nextGetAddress);
};
const nextGetAddress = (data) => {
    let optProvince = '<option value="">Select your Province</option>';
    optProvince = optProvince + data.address.provinces.map(item =>
        optProvince = `
            <option value="${item.code}">${item.full_name}</option>
            `
        );
    $('#province_code-add').html(optProvince);
    $('#province_code-update').html(optProvince);
};
const nextSelectProvince = (data) => {
    let optDistrict = '';
    optDistrict = optDistrict + data.address.districts.map(item =>
        optDistrict = `
            <option value="${item.code}">${item.full_name}</option>
            `
        );
    $('#district_code-add').html(optDistrict);
    $('#district_code-update').html(optDistrict);
};
const nextSelectDistrict = (data) => {
    let optWard = '';
    optWard = optWard + data.address.wards.map(item =>
        optWard = `
            <option value="${item.code}">${item.full_name}</option>
            `
        );
    $('#ward_code-add').html(optWard);
    $('#ward_code-add').val(data[0]);
    $('#ward_code-update').html(optWard);
    $('#ward_code-update').val(data[0]);
};
