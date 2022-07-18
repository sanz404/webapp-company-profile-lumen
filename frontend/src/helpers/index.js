import DataTable from 'datatables.net-bs5'

function authHeader() {
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

function setDataTable(url, columns, element) {
    new DataTable(element, {
        "ajax": {
            'url': url,
            'type': 'POST',
            'headers': authHeader(),
            "contentType": "application/json",
            "data": function (d) {
                return JSON.stringify(d);
            }
        },
        'processing': true,
        'serverSide': true,
        'columns': columns,
        "autoWidth": false,
        "responsive": false,
        "destroy": true,
        'order': [0, 'desc']
    })
}

function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = error => reject(error);
    });
}

function getContentByKey(key, arr) {
    if (arr.length > 0) {
        let obj = arr.find(o => o.key_name === key);
        return obj ? obj.key_value : key
    }
    return key
}

function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}


export default {
    authHeader,
    setDataTable,
    getBase64,
    getContentByKey,
    getParameterByName
}