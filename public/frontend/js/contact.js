function validateContact() {
    event.preventDefault();
    let isValid = true;

    // Get form elements
    const fullName = document.getElementById("fullName").value.trim();
    const phoneNumber = document.getElementById("phoneNumber").value.trim();
    const email = document.getElementById("email").value.trim();
    const title = document.getElementById("title").value.trim();
    const detail = document.getElementById("detail").value.trim();

    // Clear previous errors
    document.getElementById("fullNameError").innerText = "";
    document.getElementById("phoneNumberError").innerText = "";
    document.getElementById("emailError").innerText = "";
    document.getElementById("titleError").innerText = "";
    document.getElementById("detailError").innerText = "";

    if (fullName === "") {
        document.getElementById("fullNameError").innerText =
            "Vui lòng nhập họ tên";
        isValid = false;
    }

    if (phoneNumber === "") {
        document.getElementById("phoneNumberError").innerText =
            "Vui lòng nhập số điện thoại";
        isValid = false;
    } else {
        var phonePattern = /^(0[1-9])+([0-9]{8,9})\b$/;
        if (!phonePattern.test(phoneNumber)) {
            document.getElementById("phoneNumberError").innerText =
                "Số điện thoại không hợp lệ";
            isValid = false;
        }
    }

    if (email === "") {
        document.getElementById("emailError").innerText = "Vui lòng nhập email";
        isValid = false;
    } else {
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            document.getElementById("emailError").innerText =
                "Email không hợp lệ";
            isValid = false;
        }
    }

    if (title === "") {
        document.getElementById("titleError").innerText =
            "Vui lòng nhập tiêu đề";
        isValid = false;
    }

    if (detail === "") {
        document.getElementById("detailError").innerText =
            "Vui lòng nhập nội dung";
        isValid = false;
    }

    if (isValid) {
        const csrfToken = document.querySelector('input[name="_token"]').value;

        $.ajax({
            url: "/send-contact",
            method: "POST",
            data: {
                _token: csrfToken,
                fullName: fullName,
                phoneNumber: phoneNumber,
                email: email,
                title: title,
                detail: detail,
            },
            success: function (response) {
                if (response.success) {
                    alert("Đánh giá của bạn đã được gửi thành công.");
                    // Tải lại trang hoặc làm điều gì đó khác
                    location.reload();
                } else {
                    alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");
                }
            },
            error: function () {
                alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");
            },
        });
    }

    return false;
}
