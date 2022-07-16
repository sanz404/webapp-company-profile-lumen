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

function categoriesArticle() {
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/articles/categories`, requestOptions).then(handleResponse);
}


function detailArticle(id) {
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/articles/detail/`+id, requestOptions).then(handleResponse);
}

function deleteArticle(id) {
    const requestOptions = {
        method: 'DELETE',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/articles/delete/`+id, requestOptions).then(handleResponse);
}


function createArticle(data) {
    const requestOptions = {
        method: 'POST',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/articles/create`, requestOptions).then(handleResponse);
}

function updateArticle(data, id) {
    const requestOptions = {
        method: 'PUT',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/articles/update/`+id, requestOptions).then(handleResponse);
}

export default { detailArticle, deleteArticle, createArticle, updateArticle, categoriesArticle }