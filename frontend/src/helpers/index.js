import DataTable from 'datatables.net-bs5'

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

function setDataTable(url, columns, element){
    new DataTable(element, {
        "language": {
            "sLengthMenu": "Show Entries : _MENU_"
        },
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
        'order':[0, 'desc']
    })
}


export default { authHeader, setDataTable }