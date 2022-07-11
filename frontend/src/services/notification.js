import helper from "../helpers/index"

function handleResponse(response) {
    return response.text().then(text => {
        const data = text && JSON.parse(text);
        if (!response.ok) {
            const error = (data && data.message) || response.statusText;
            return Promise.reject(error);
        }
        return data;
    });
}

function detailNotification(id) {
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/account/notifications/detail/`+id, requestOptions).then(handleResponse);
}

function currentNotification(){
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/account/notifications/current`, requestOptions).then(handleResponse);
}

function deleteNotification(id) {
    const requestOptions = {
        method: 'DELETE',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/account/notifications/delete/`+id, requestOptions).then(handleResponse);
}

export default { detailNotification, currentNotification, deleteNotification }