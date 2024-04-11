
function loadContent(url) {
    fetch(url)
        .then((response) => response.text())
        .then(data => {
            // Update the content of the #content element with the fetched data
            document.getElementById('content').innerHTML = data;
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// default
// loadContent('../view/BookARoom.php')
