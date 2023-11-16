$(document).ready(function () {
    getAddress();
})

const getAddress = (code = '', keyword = '') => {
    let api = API_GET_ADDRESS;
    let dataSearch = {
        code: code,
        keyword: keyword,
    };
    getData(api, dataSearch, nextGetAddress);
}
const nextGetAddress = (data) => {
    let optProvince = `<option value="">Select your provice</option>`;
    let optDistrict = `<option value="">Select your district</option>`;
    let optWard = `<option value="">Select your ward</option>`;
    optProvince = data.address.provinces.map(item => optProvince += `<option value="${item.code}">${item.full_name}</option>`);
    $('#province_code-add').append(optProvince);
}