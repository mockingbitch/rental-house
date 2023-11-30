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
$('.cancel-btn').on('click', function() {
    var x = document.getElementById("create-form");
    x.style.display = "none";
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
    console.log(item);
    for (let key in item) {
        if (item.hasOwnProperty(key)) {
            $(`#${key}-${type}`).val(item[key])
        }
    }
}