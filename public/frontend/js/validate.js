async function validateRegister() {
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
        return true;
    } else {
        return false;
    }
}

// Validate account and check if it exists in database using AJAX
function validateAccount(account) {
    return new Promise((resolve, reject) => {
        // Tạo request AJAX
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/check-account", true);
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
