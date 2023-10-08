document.addEventListener("DOMContentLoaded", function() {
    const loginButton = document.getElementById("btn-login");
    const registerButton = document.getElementById("btn-register");
    const updateButton = document.getElementById("btn-update");
    const errorSpan = document.getElementById("error");
    const deleteButtons = document.querySelectorAll('.btn-danger');
    const modal = document.getElementById("modal");
    const closeModalButton = document.getElementById("closeModal");
    const confirmDeleteButton = document.getElementById("confirmDelete");
    const migrateDbButton = document.getElementById("migrateDb");

    if(registerButton){
        registerButton.addEventListener("click", function(e) {
            e.preventDefault();
            errorSpan.classList.add('hidden');
            
            const name = document.getElementById("first_name").value;
            const lastName = document.getElementById("last_name").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
    
            if (!name || !lastName || !email || !password || !confirmPassword) {
                showError("Todos los campos son obligatorios.");
                return;
            }
            if (password !== confirmPassword) {
                showError("Las contraseñas no coinciden.");
                return;
            }
    
            fetch("insertuser", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },            
                body: JSON.stringify({
                    "first_name": name, 
                    "last_name": lastName, 
                    "email": email, 
                    "password": password, 
                    "confirm_password": confirmPassword 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(page);
                    if(page === 'register'){
                        alert("Registro exitoso. Serás redirigido a la página de inicio de sesión.");
                        window.location.href = "login";
                    }else{
                        window.location.href = "users";
                    }
                } else {
                    showError("Error: " + data.message);
                }
            })
            .catch(error => {
                console.error("Connection error:");
                console.error(error);
            });
        });
    }
    
    if(updateButton){
        updateButton.addEventListener("click", function(e) {
            e.preventDefault();
            errorSpan.classList.add('hidden');
            
            const name = document.getElementById("first_name").value;
            const lastName = document.getElementById("last_name").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const userID = document.getElementById("userid").value;
    
            if (!name) {
                showError("Por favor complete el campo de nombre.");
                return;
            }
            if (!lastName) {
                showError("Por favor complete el campo de apellido.");
                return;
            }
            if (!email) {
                showError("Por favor complete el campo de correo electrónico.");
                return;
            }
            if (password !== confirmPassword) {
                showError("Las contraseñas no coinciden.");
                return;
            }
    
            fetch(homeUrl + "index.php/updateuser", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },            
                body: JSON.stringify({
                    "first_name": name, 
                    "last_name": lastName, 
                    "email": email, 
                    "password": password, 
                    "confirm_password": confirmPassword,
                    "id": userID
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = homeUrl + "index.php/users";
                } else {
                    showError("Error: " + data.message);
                }
            })
            .catch(error => {
                console.error("Connection error:");
                console.error(error);
            });
        });
    }

    if(loginButton){
        loginButton.addEventListener("click", function(e) {
            e.preventDefault();
            errorSpan.classList.add('hidden');
            
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            
            if (!email || !password) {
                showError("Por favor ingrese email y contraseña.");
                return;
            }
    
            fetch("signin", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },            
                body: JSON.stringify({
                    "email": email, 
                    "password": password
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    window.location.href = "users";
                } else {
                    showError("Error: " + data.message);
                }
            })
            .catch(error => {
                console.error("Connection error:");
                console.error(error);
            });
        });
    }

    function showError(message){
        errorSpan.innerHTML = message;
        errorSpan.classList.remove('hidden');
    }

    if(deleteButtons){
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const dataId = this.getAttribute('data-id');
                document.getElementById('confirmDelete').setAttribute('data-id', dataId);
                console.log(`ID: ${dataId}`);
                showModal();
            });
        });
    }

    if(confirmDeleteButton){
        confirmDeleteButton.addEventListener("click", function () {
            const userID = this.getAttribute('data-id');

            fetch("deleteuser", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },            
                body: JSON.stringify({
                    "userID": userID
                })
            })
            .then(response => response.json())
            .then(data => {
                closeModal();
                const row = document.querySelector(`tr[data-rowid="${userID}"]`);
                row.classList.add('hide');
                setTimeout(() => {
                    row.remove();
                }, 300);      
            })
            .catch(error => {
                console.error("Connection error:");
                console.error(error);
            });
        });
    }

    if(closeModalButton){
        closeModalButton.addEventListener("click", function () {
            closeModal();
        });    
    }
    
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });
    
    function closeModal(){
        modal.style.display = "none";
    }

    function showModal(){
        modal.style.display = "flex";
    }

    if(migrateDbButton){
        migrateDbButton.addEventListener("click", function () {
            fetch(homeUrl + "createdb.php", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {    
                if (data.success) {
                    window.location.href = homeUrl + "index.php/login";
                } else {
                    showError("Error: " + data.message);
                }
            })
            .catch(error => {
                showError(error);
            });
        });            
    }
});
