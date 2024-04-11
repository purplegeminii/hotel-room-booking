
function search4room(event) {
    event.preventDefault(); // Prevent form submission

    const search = document.getElementById("search").value;
    const url = "../actions/search4room.php?search=" + search;

    const headers = {
        "Accept": "application/json",
        "Content-type": "application/json"
    };

    fetch(url, {
        method: "GET",
        headers: headers
    })
        .then((response) => response.json())
        .then((response) => {
            console.log(response);
            if (response.status === 1) {
                document.getElementById('content2').innerHTML = response.result;
            } else {

            }
        })
        .catch((err) => {
            console.log(err);
        })
}