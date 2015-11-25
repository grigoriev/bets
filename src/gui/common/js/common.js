function syncPost(actionUrl, requestParam, callback) {
    $.ajax({
        contentType: 'application/json',
        type: 'post',
        url: actionUrl,
        data: JSON.stringify(requestParam),
        dataType: 'json',
        success: callback,
        async: false
    });
}

function syncGet(actionUrl, callback, requestParam) {
    $.ajax({
        contentType: 'application/json',
        type: 'get',
        url: actionUrl,
        data: JSON.stringify(requestParam),
        dataType: 'json',
        success: callback,
        async: false
    });
}

function asyncGet(actionUrl, callback, requestParam) {
    $.ajax({
        contentType: 'application/json',
        type: 'get',
        url: actionUrl,
        data: JSON.stringify(requestParam),
        dataType: 'json',
        success: callback,
        async: true
    });
}
