function authHeader(){
    let user = JSON.parse(localStorage.getItem('user'));
    if (user && user.token) {
        return { 
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + user.token 
        };
    } else {
        return {};
    }
}

function isAuth(){
    let user = JSON.parse(localStorage.getItem('user'));
    if (user && user.token) {
        return true;
    }
    return false;
}


export default { authHeader, isAuth }