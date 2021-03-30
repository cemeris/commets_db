function postSubmit(event) {
    event.preventDefault();
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

            success.bind(this)(event)
        }
    };
    xhttp.open("POST", "demo_post.asp", true);
    xhttp.send();
}

function success(e) {
    alert();
    //document.getElementById("demo").innerHTML = this.responseText;
}