function postSubmit(ev, callback) {
    ev.preventDefault();
    var url = this.getAttribute('action');
    var data = new FormData(this);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            callback(JSON.parse(this.response));
        }
    };
    xhttp.open("POST", url, true);
    xhttp.send(data);
}

function postFromLink(ev) {
    ev.preventDefault();
    var url = this.getAttribute('href');
    var element = this.parentElement;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            deleteListElement(element);
        }
    };
    xhttp.open("POST", url, true);
    xhttp.send();
}

function addElement(data) {
    console.log(data);
    var ul = document.querySelector('.entry-list');
    var new_li = document.createElement('li');

    new_li.innerHTML = `
        <span>` + data.name + `</span>
        %s
        <a href="update.php?update=%s">Update</a>
        <a href="request.php?delete=%s" class="delete" onclick="postFromLink.bind(this)(event)">x</a>
    '`;


    ul.append(new_li);
}

function updateElement(data) {

}

function deleteListElement(element) {
    element.remove();
}

