function postSubmit(event) {
    let url = this.getAttribute('action');
    var data = new FormData(this);

    event.preventDefault();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            success.bind(this)(event)
        }
    };
    xhttp.open("POST", url, true);
    xhttp.send(data);
}

function success(e) {
    alert();
}

