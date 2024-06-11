async function validateRegister() {
    event.preventDefault(); // Ngăn chặn sự kiện submit mặc định
    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const fullname = document.getElementById("fullname").value.trim();
    const account = document.getElementById("account").value.trim();
    const password = document.getElementById("password").value.trim();

    // Lấy các div hiển thị lỗi
    const fullnameError = document.getElementById("fullnameError");
    const accountError = document.getElementById("accountError");
    const passwordError = document.getElementById("passwordError");

    fullnameError.textContent = "";
    accountError.textContent = "";
    passwordError.textContent = "";

    // Validate fullname
    if (!fullname) {
        fullnameError.textContent = "Họ & tên không được để trống";
        isValid = false;
    }

    if (!account) {
        accountError.textContent = "Tên đăng nhập không được để trống";
        isValid = false;
    } else if (account.length < 6) {
        accountError.textContent = "Tên đăng nhập phải chứa ít nhất 6 ký tự";
        isValid = false;
    } else if (!/^[a-zA-Z][a-zA-Z0-9]*$/.test(account)) {
        accountError.textContent =
            "Tên đăng nhập phải bắt đầu bằng chữ cái và không chứa ký tự đặc biệt";
        isValid = false;
    } else {
        try {
            await validateAccount(account);
        } catch (error) {
            accountError.textContent = error;
            isValid = false;
        }
    }

    // Validate password
    if (!password) {
        passwordError.textContent = "Mật khẩu không được để trống";
        isValid = false;
    } else if (password.length < 6) {
        passwordError.textContent = "Mật khẩu phải chứa ít nhất 6 ký tự";
        isValid = false;
    } else if (
        !/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/.test(
            password
        )
    ) {
        passwordError.innerHTML =
            "<p class='mb-0'>Mật khẩu phải chứa:</p>" +
            "<p class='mb-0'>   • Chữ hoa</p>" +
            "<p class='mb-0'>   • Chữ thường</p>" +
            "<p class='mb-0'>   • Chữ số</p>" +
            "<p class='mb-0'>   • Ký tự đặc biệt</p>";
        isValid = false;
    }

    if (isValid) {
        document.querySelector(".form-register").submit();
    }
}

function validateAccount(account) {
    return new Promise((resolve, reject) => {
        // Tạo request AJAX
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/check-account", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
        // Xử lý kết quả nhận được từ server
        xhr.onload = () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    // Nếu account đã tồn tại trong DB, trả về false
                    reject("Tên đăng nhập đã tồn tại");
                } else {
                    // Nếu account chưa tồn tại trong DB, trả về true
                    resolve(true);
                }
            } else {
                // Xử lý lỗi
                reject("Đã xảy ra lỗi khi kiểm tra tên đăng nhập");
            }
        };

        // Gửi request với dữ liệu là tên đăng nhập cần kiểm tra
        xhr.send(JSON.stringify({ account: account }));
    });
}

function validateLogin() {
    event.preventDefault(); // Ngăn chặn sự kiện submit mặc định
    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const account = document.getElementById("account-login").value.trim();
    const password = document.getElementById("password-login").value.trim();

    // Lấy các div hiển thị lỗi
    const accountError = document.getElementById("account-login-error");
    const passwordError = document.getElementById("password-login-error");

    accountError.textContent = "";
    passwordError.textContent = "";

    if (!account) {
        accountError.textContent = "Vui lòng nhập tên đăng nhập";
        isValid = false;
    }

    if (!password) {
        passwordError.textContent = "Vui lòng nhập mật khẩu";
        isValid = false;
    }

    if (isValid) {
        $.ajax({
            url: '{{ route("login") }}',
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                account: account,
                password: password,
            },
            success: function (response) {
                if (response.success) {
                    // Redirect to the intended page or home page
                    window.location.href = '{{ url("/home") }}';
                } else {
                    passwordError.textContent = response.message;
                }
            },
            error: function (response) {
                if (response.status === 401) {
                    passwordError.textContent = response.responseJSON.message;
                } else {
                    passwordError.textContent =
                        "Có lỗi xảy ra. Vui lòng thử lại.";
                }
            },
        });
    }
}
