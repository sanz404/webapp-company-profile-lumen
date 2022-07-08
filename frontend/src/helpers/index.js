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


export default { authHeader }