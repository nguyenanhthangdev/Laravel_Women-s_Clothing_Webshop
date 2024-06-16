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

function checkLogin() {
    const isLoggedIn =
        document.querySelector('meta[name="user-logged-in"]').content ===
        "true";
    if (isLoggedIn) {
        window.location.href = "/checkout";
    } else {
        // Nếu chưa đăng nhập, hiển thị thông báo yêu cầu đăng nhập
        alert("Vui lòng đăng nhập để tiếp tục thanh toán.");
    }
}

function logout() {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    $.ajax({
        url: "/logout",
        method: "POST",
        data: {
            _token: csrfToken,
        },
        success: function (response) {
            if (response.success) {
                window.location.reload();
                alert("Đã đăng xuất khỏi tài khoản của bạn.")
            } else {
                alert("Đăng xuất không thành công. Vui lòng thử lại!");
            }
        },
        error: function (xhr, status, error) {
            alert("Đã có lỗi xảy ra. Vui lòng thử lại sau!");
        },
    });
}
