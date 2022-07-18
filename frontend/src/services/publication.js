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

function getProduct() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/product/load`, requestOptions).then(handleResponse);
}

function getProject() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/project/load`, requestOptions).then(handleResponse);
}


function getProjectById(id) {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/project/find/`+id, requestOptions).then(handleResponse);
}



function getHomeArticle() {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/home/article`, requestOptions).then(handleResponse);
}

function getArticleBySlug(slug) {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/article/read/`+slug, requestOptions).then(handleResponse);
}

function sendComment(data) {
    const requestOptions = {
        method: 'POST',
        headers: helper.authHeader(),
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/article/comment/send`, requestOptions).then(handleResponse);
}

function getListArticle(data) {
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/article/list`, requestOptions).then(handleResponse);
}

function getArticleCategories(data) {
    const requestOptions = {
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/article/categories`, requestOptions).then(handleResponse);
}

export default { 
    contactSend, 
    getContent, 
    getFeature, 
    getHomeArticle, 
    getAbout, 
    getTeam, 
    getFaq, 
    getProduct, 
    getProject, 
    getProjectById, 
    getArticleBySlug, 
    getListArticle,
    getArticleCategories,
    sendComment
}