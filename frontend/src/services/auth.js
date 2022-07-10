import VueCookies from 'vue-cookies'

export default { 
    login,
    logout,
    register,
    forgot_password,
    reset_password,
    confirm
 }

function handleResponse(response) {
    return response.text().then(text => {
        const data = text && JSON.parse(text);
        if (!response.ok) {
            if (response.status === 401) {
                // auto logout if 401 response returned from api
                logout();
            }
            const error = (data && data.message) || response.statusText;
            return Promise.reject(error);
        }

        return data;
    });
}

function login(username, password, remember_me) {

    //console.log(remember_me)

    let formData = JSON.stringify({
        "credential":username,
        "password":password
    })

    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: formData
    };

    return fetch(`${process.env.VUE_APP_SERVICE}/auth/login`, requestOptions)
        .then(handleResponse)
        .then(user => {
            // login successful if there's a jwt token in the response
            if (user.token) {
                // store user details and jwt token in local storage to keep user logged in between page refreshes
                localStorage.setItem('user', JSON.stringify(user));
            }

            if(remember_me){
                VueCookies.set('user', user) ;
            }

            return user;
        });
}

function forgot_password(email){
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ "email": email })
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/auth/forgot_password`, requestOptions).then(handleResponse);
}

function register(user) {
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(user)
    };

    return fetch(`${process.env.VUE_APP_SERVICE}/auth/register`, requestOptions).then(handleResponse);
}

function reset_password(user) {
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(user)
    };

    return fetch(`${process.env.VUE_APP_SERVICE}/auth/reset_password`, requestOptions).then(handleResponse);
}

function confirm(token){
    const requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ "token": token })
    };
    return fetch(`${process.env.VUE_APP_SERVICE}/auth/confirm`, requestOptions).then(handleResponse);
}


function logout() {
    // remove user from local storage to log user out
    let user = VueCookies.get('user');
    if(user){
        VueCookies.remove('user');
    }
    localStorage.removeItem('user');
}