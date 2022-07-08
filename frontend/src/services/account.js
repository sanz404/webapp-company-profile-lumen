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

function updatePassword(data) {
    const requestOptions = {
        method: 'POST',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/account/password/update`, requestOptions).then(handleResponse);
}

function getProfile(){
    const requestOptions = {
        method: 'POST',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/account/profile`, requestOptions).then(handleResponse);
}

function updateProfile(data) {
    const requestOptions = {
        method: 'POST',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/account/profile/update`, requestOptions).then(handleResponse);
}

function getCountries(){
    const requestOptions = {
        method: 'GET',
        headers: helper.authHeader()
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/account/countries`, requestOptions).then(handleResponse);
}

export default { updatePassword, getProfile, updateProfile, getCountries }