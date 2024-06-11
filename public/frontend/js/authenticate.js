// Hiển thị form đăng ký
function showRegisterModal() {
    var modal = document.getElementById("registerModal");
    modal.style.display = "block";
}

// Ẩn form đăng ký
function closeRegisterModal() {
    var modal = document.getElementById("registerModal");
    modal.style.display = "none";
}

// Hiển thị form đăng ký
function showLoginModal() {
    var modal = document.getElementById("loginModal");
    modal.style.display = "block";
}

// Ẩn form đăng ký
function closeLoginModal() {
    var modal = document.getElementById("loginModal");
    modal.style.display = "none";
}

document.addEventListener("DOMContentLoaded", function () {
    const loginLink = document.getElementById("login-link");
    const registerLink = document.getElementById("register-link");

    if (loginLink) {
        loginLink.addEventListener("click", function (event) {
            event.preventDefault();
            closeRegisterModal();
            showLoginModal();
        });
    }

    if (registerLink) {
        registerLink.addEventListener("click", function (event) {
            event.preventDefault();
            closeLoginModal();
            showRegisterModal();
        });
    }
});
