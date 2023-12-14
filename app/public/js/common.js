$(document).on("click", ".open-add-modal", function (e) {
    resetForm($(this).data('target'));
    hideMessageValidate($(this).data('target'))
});

function errorFunction(request) {
    let message = request?.responseJSON?.message ?? '';
    switch (request.status) {
        case 403:
            message = message ?? "Bạn không có quyền thực hiện hành động này.";
            break;
        case 404:
            message = "Không tìm thấy dữ liệu.";
            break;
        case 400:
            if (request.responseJSON.message !== undefined) {
                message = request.responseJSON.message;
            } else message = "Có lỗi xảy ra. Vui lòng thử lại sau ít phút";
            break;
        case HTTP_NOT_IMPLEMENTED:
            message = message ?? "Không thể thực hiện yêu cầu này";
            break;
        default:
            message = "Có lỗi xảy ra. Vui lòng thử lại sau ít phút";
    }
    toastAlert(message, "", "error");
}

/**
 *  action for call api with GET method like list, search, detail,...
 * @param api
 * @param data
 * @param nextAction
 */
function getData(api, data, nextAction) {
    $.ajax({
        url: api,
        type: 'GET',
        data: {
            data
        },
        beforeSend: function() {
            $('.loading').show();
        },
        complete: function(){
            $('.loading').hide();
        },
        success: function (response) {
            nextAction(response);
        },
        error: function (request, error) {
            errorFunction(request);
        }
    });
}

/**
 * action for call api with POST method like create, update, delete,...
 * @param api
 * @param data
 * @param nextAction
 */
function createOrUpdate(api, data, nextAction) {
    $.ajax({
        url: api,
        type: 'POST',
        data: data,
        beforeSend: function() {
            $('.loading').show();
        },
        complete: function(){
            $('.loading').hide();
        },
        success: function (response) {
            nextAction(response);
        },
        error: function (request, error) {
            errorFunction(request)
        }
    });
}


/**
 * action for call api with POST method like create, update, delete,...with file
 * @param api
 * @param data
 * @param nextAction
 */
function createOrUpdateWithFile(api, data, nextAction) {
    $.ajax({
        url: api,
        type: 'POST',
        data: data,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $('.loading').show();
        },
        complete: function(){
            $('.loading').hide();
        },
        success: function (response) {
            nextAction(response);
        },
        error: function (request, error) {
            errorFunction(request)
        }
    });
}

const scrollToTop = () => {
    const c = document.documentElement.scrollTop || document.body.scrollTop;
    if (c > 0) {
        window.requestAnimationFrame(scrollToTop);
        window.scrollTo(0, c - c / 8);
    }
};
