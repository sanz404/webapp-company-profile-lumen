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

function detailFeature(id) {
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/features/detail/`+id, requestOptions).then(handleResponse);
}

function deleteFeature(id) {
    const requestOptions = {
        method: 'DELETE',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/features/delete/`+id, requestOptions).then(handleResponse);
}


function createFeature(data) {
    const requestOptions = {
        method: 'POST',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/features/create`, requestOptions).then(handleResponse);
}

function updateFeature(data, id) {
    const requestOptions = {
        method: 'PUT',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/features/update/`+id, requestOptions).then(handleResponse);
}

function fontFeature() {
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/features/fontawesomes`, requestOptions).then(handleResponse);
}


export default { detailFeature, deleteFeature, createFeature, updateFeature, fontFeature }