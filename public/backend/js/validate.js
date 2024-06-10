// Thêm từ khóa async trước khai báo hàm
async function validateFormUserAdd(event) {
    event.preventDefault(); // Ngăn chặn sự kiện submit mặc định

    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const fullname = document.getElementById("fullname").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();
    const status = document.getElementById("status").value.trim();

    // Lấy các div hiển thị lỗi
    const fullnameError = document.getElementById("fullnameError");
    const emailError = document.getElementById("emailError");
    const phoneError = document.getElementById("phoneError");
    const usernameError = document.getElementById("usernameError");
    const passwordError = document.getElementById("passwordError");
    const statusError = document.getElementById("statusError");

    fullnameError.textContent = "";
    emailError.textContent = "";
    phoneError.textContent = "";
    usernameError.textContent = "";
    passwordError.textContent = "";
    statusError.textContent = "";

    // Validate fullname
    if (!fullname) {
        fullnameError.textContent = "Họ & tên không được để trống";
        isValid = false;
    }

    // Validate email format
    if (!email) {
        emailError.textContent = "Email không được để trống";
        isValid = false;
    } else if (!isValidEmail(email)) {
        emailError.textContent = "Email không hợp lệ";
        isValid = false;
    }

    // Validate phone format
    const phonePattern = /^(0[1-9])+([0-9]{8,9})\b$/; // Mẫu cho số điện thoại có độ dài chính xác là 10 chữ số
    if (!phone) {
        phoneError.textContent = "Số điện thoại không được để trống";
        isValid = false;
    } else if (!phonePattern.test(phone)) {
        phoneError.textContent = "Số điện thoại không hợp lệ";
        isValid = false;
    }

    if (!username) {
        usernameError.textContent = "Tên đăng nhập không được để trống";
        isValid = false;
    } else if (username.length < 6) {
        usernameError.textContent = "Tên đăng nhập phải chứa ít nhất 6 ký tự";
        isValid = false;
    } else if (!/^[a-zA-Z][a-zA-Z0-9_]*$/.test(username)) {
        usernameError.textContent =
            "Tên đăng nhập phải bắt đầu bằng chữ cái và không chứa ký tự đặc biệt";
        isValid = false;
    } else {
        try {
            await validateUsername(username);
        } catch (error) {
            usernameError.textContent = error;
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

    // Validate status
    if (!status) {
        statusError.textContent = "Vui lòng chọn trạng thái";
        isValid = false;
    }

    if (isValid) {
        // Form is valid, proceed with form submission
        document.querySelector("form").submit();
    }
}

// Biểu thức chính quy kiểm tra định dạng email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Validate username and check if it exists in database using AJAX
function validateUsername(username) {
    return new Promise((resolve, reject) => {
        // Tạo request AJAX
        const csrfToken = document.querySelector('input[name="_token"]').value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/admin/check-username", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
        // Xử lý kết quả nhận được từ server
        xhr.onload = () => {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    // Nếu username đã tồn tại trong DB, trả về false
                    reject("Tên đăng nhập đã tồn tại");
                } else {
                    // Nếu username chưa tồn tại trong DB, trả về true
                    resolve(true);
                }
            } else {
                // Xử lý lỗi
                reject("Đã xảy ra lỗi khi kiểm tra tên đăng nhập");
            }
        };

        // Gửi request với dữ liệu là tên đăng nhập cần kiểm tra
        xhr.send(JSON.stringify({ username: username }));
    });
}

// Gán sự kiện submit cho form để sử dụng hàm validateFormUser
document.querySelector(".form-add-user").addEventListener("submit", validateFormUserAdd);

function validateFormUserEdit() {
    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const fullname = document.getElementById("fullname").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    // const username = document.getElementById("username").value.trim();
    // const password = document.getElementById("password").value.trim();
    const status = document.getElementById("status").value.trim();

    // Lấy các div hiển thị lỗi
    const fullnameError = document.getElementById("fullnameError");
    const emailError = document.getElementById("emailError");
    const phoneError = document.getElementById("phoneError");
    const statusError = document.getElementById("statusError");

    fullnameError.textContent = "";
    emailError.textContent = "";
    phoneError.textContent = "";
    statusError.textContent = "";

    // Validate fullname
    if (!fullname) {
        fullnameError.textContent = "Họ & tên không được để trống";
        isValid = false;
    } else {
        fullnameError.textContent = "";
    }

    // Validate email format
    if (!email) {
        emailError.textContent = "Email không được để trống";
        isValid = false;
    } else if (!isValidEmail(email)) {
        emailError.textContent = "Email không hợp lệ";
        isValid = false;
    } else {
        emailError.textContent = "";
    }

    // Validate phone format
    const phonePattern = /^(0[1-9])+([0-9]{8,9})\b$/; // Mẫu cho số điện thoại có độ dài chính xác là 10 chữ số
    if (!phone) {
        phoneError.textContent = "Số điện thoại không được để trống";
        isValid = false;
    } else if (!phonePattern.test(phone)) {
        phoneError.textContent = "Số điện thoại không hợp lệ";
        isValid = false;
    } else {
        phoneError.textContent = "";
    }

    // Validate status
    if (!status) {
        statusError.textContent = "Vui lòng chọn trạng thái";
        isValid = false;
    } else {
        statusError.textContent = "";
    }

    return isValid;
}

// Gán sự kiện submit cho form để sử dụng hàm validateFormUser
document.querySelector(".form-edit-user").addEventListener("submit", validateFormUserEdit);

function validateFormManufacturerAdd() {
    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const name = document.getElementById("name").value.trim();
    const featured = document.getElementById("featured").value;
    const status = document.getElementById("status").value;

    // Lấy các div hiển thị lỗi
    const nameError = document.getElementById("nameError");
    const featuredError = document.getElementById("featuredError");
    const statusError = document.getElementById("statusError");

    nameError.textContent = "";
    featuredError.textContent = "";
    statusError.textContent = "";

    // Validate fullname
    if (!name) {
        nameError.textContent = "Tên thương hiệu không được để trống";
        isValid = false;
    } else {
        nameError.textContent = "";
    }

    if (!featured) {
        featuredError.textContent = "Vui lòng chọn tính nổi bật";
        isValid = false;
    } else {
        statusError.textContent = "";
    }

    // Validate status
    if (!status) {
        statusError.textContent = "Vui lòng chọn trạng thái";
        isValid = false;
    } else {
        statusError.textContent = "";
    }

    return isValid;
}

// Gán sự kiện submit cho form để sử dụng hàm validateFormUser
document.querySelector(".form-manufacturer").addEventListener("submit", validateFormManufacturerAdd);

function validateFormCategoryAdd() {
    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const name = document.getElementById("name").value.trim();
    const featured = document.getElementById("featured").value;
    const status = document.getElementById("status").value;

    // Lấy các div hiển thị lỗi
    const nameError = document.getElementById("nameError");
    const featuredError = document.getElementById("featuredError");
    const statusError = document.getElementById("statusError");

    nameError.textContent = "";
    featuredError.textContent = "";
    statusError.textContent = "";

    // Validate fullname
    if (!name) {
        nameError.textContent = "Tên danh mục không được để trống";
        isValid = false;
    } else {
        nameError.textContent = "";
    }

    if (!featured) {
        featuredError.textContent = "Vui lòng chọn tính nổi bật";
        isValid = false;
    } else {
        statusError.textContent = "";
    }

    // Validate status
    if (!status) {
        statusError.textContent = "Vui lòng chọn trạng thái";
        isValid = false;
    } else {
        statusError.textContent = "";
    }

    return isValid;
}

document.querySelector(".form-category").addEventListener("submit", validateFormCategoryAdd);

function validateFormProductAdd() {
    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const name = document.getElementById("name").value.trim();
    const discount = document.getElementById("discount").value.trim();
    const status = document.getElementById("status").value;

    // Lấy các div hiển thị lỗi
    const nameError = document.getElementById("nameError");
    const discountError = document.getElementById("discountError");
    const statusError = document.getElementById("statusError");

    nameError.textContent = "";
    discountError.textContent = "";
    statusError.textContent = "";

    // Validate fullname
    if (!name) {
        nameError.textContent = "Tên sản phẩm không được để trống";
        isValid = false;
    } else {
        nameError.textContent = "";
    }

    if (!discount) {
        discountError.textContent = "Giảm giá không được để trống";
        isValid = false;
    } else {
        if (!/^\d+$/.test(discount)) {
            discountError.textContent = "Giảm giá không hợp lệ";
            isValid = false;
        } else {
            discountError.textContent = "";
        }
    }

    // Validate status
    if (!status) {
        statusError.textContent = "Vui lòng chọn trạng thái";
        isValid = false;
    } else {
        statusError.textContent = "";
    }

    return isValid;
}

document.querySelector(".form-product").addEventListener("submit", validateFormProductAdd);

function validateFormColorAdd() {
    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const name = document.getElementById("name").value.trim();

    // Lấy các div hiển thị lỗi
    const nameError = document.getElementById("nameError");

    nameError.textContent = "";

    // Validate fullname
    if (!name) {
        nameError.textContent = "Màu sản phẩm không được để trống";
        isValid = false;
    } else {
        nameError.textContent = "";
    }

    return isValid;
}

document.querySelector(".form-color").addEventListener("submit", validateFormColorAdd);

function validateFormSizeAdd() {
    let isValid = true;

    // Lấy giá trị của các trường dữ liệu
    const name = document.getElementById("name").value.trim();

    // Lấy các div hiển thị lỗi
    const nameError = document.getElementById("nameError");

    nameError.textContent = "";

    // Validate fullname
    if (!name) {
        nameError.textContent = "Kích thước phẩm không được để trống";
        isValid = false;
    } else {
        nameError.textContent = "";
    }

    return isValid;
}

document.querySelector(".form-size").addEventListener("submit", validateFormSizeAdd);