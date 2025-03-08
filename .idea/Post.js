function send_post() {
    const email = document.getElementById("email").value;
    const data = new URLSearchParams();
    data.append("email", email);
    fetch("http://localhost:8080/check_user.php", {
        method: "POST",
        body: data,
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
            "Accept": "application/json"
        }
    })
        .then((response) => {
            if (response.ok) return response.json();
            else {
                return response.json().then((json) => {
                    document.getElementById("check_user_msg").textContent = "";
                    throw new Error(json.message || "Network response was not ok");
                });
            }
        })
        .then(json => { document.getElementById("check_user_msg").textContent = json.message;})
        .catch(error => {console.log(error.message);});
}