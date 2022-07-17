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

function contactSend(data) {
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/contact/send`, requestOptions).then(handleResponse);
}

function getContent() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/content/load`, requestOptions).then(handleResponse);
}

function getFeature() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/feature/load`, requestOptions).then(handleResponse);
}

function getAbout() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/about/load`, requestOptions).then(handleResponse);
}


function getTeam() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/team/load`, requestOptions).then(handleResponse);
}

function getFaq() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/faq/load`, requestOptions).then(handleResponse);
}


function getHomeArticle() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/home/article`, requestOptions).then(handleResponse);
}

export default { contactSend, getContent, getFeature, getHomeArticle, getAbout, getTeam, getFaq }