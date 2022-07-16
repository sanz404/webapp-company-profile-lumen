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

function categoriesProject() {
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/projects/categories`, requestOptions).then(handleResponse);
}


function detailProject(id) {
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/projects/detail/`+id, requestOptions).then(handleResponse);
}

function deleteProject(id) {
    const requestOptions = {
        method: 'DELETE',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/projects/delete/`+id, requestOptions).then(handleResponse);
}


function createProject(data) {
    const requestOptions = {
        method: 'POST',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/projects/create`, requestOptions).then(handleResponse);
}

function updateProject(data, id) {
    const requestOptions = {
        method: 'PUT',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/main/projects/update/`+id, requestOptions).then(handleResponse);
}

export default { detailProject, deleteProject, createProject, updateProject, categoriesProject }