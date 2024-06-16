function showAddShippingModal() {
    var modal = document.getElementById("addShippingModal");
    modal.style.display = "block";
    var modal = document.getElementById("showAllShippingModal");
    modal.style.display = "none";
}

function closeAddShippingModal() {
    var modal = document.getElementById("addShippingModal");
    modal.style.display = "none";
}

function validateShipping() {
    event.preventDefault();
    let isValid = true;

    // Get form elements
    const fullName = document.getElementById("fullName").value.trim();
    const phoneNumber = document.getElementById("phoneNumber").value.trim();
    const email = document.getElementById("email").value.trim();
    const city = document.getElementById("city").value.trim();
    const district = document.getElementById("district").value.trim();
    const ward = document.getElementById("ward").value.trim();
    const specific = document.getElementById("specific").value.trim();
    const addressType = document.querySelector(
        'input[name="radio-shipping"]:checked'
    ).value;

    // Clear previous errors
    document.getElementById("fullNameError").innerText = "";
    document.getElementById("phoneNumberError").innerText = "";
    document.getElementById("emailError").innerText = "";
    document.getElementById("cityError").innerText = "";
    document.getElementById("districtError").innerText = "";
    document.getElementById("wardError").innerText = "";
    document.getElementById("specificError").innerText = "";

    // Validate each field
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

    if (city === "") {
        document.getElementById("cityError").innerText =
            "Vui lòng chọn thành phố";
        isValid = false;
    }

    if (district === "") {
        document.getElementById("districtError").innerText =
            "Vui lòng chọn quận huyện";
        isValid = false;
    }

    if (ward === "") {
        document.getElementById("wardError").innerText =
            "Vui lòng chọn xã phường";
        isValid = false;
    }

    if (specific === "") {
        document.getElementById("specificError").innerText =
            "Vui lòng nhập địa chỉ cụ thể";
        isValid = false;
    }

    if (isValid) {
        submitShippingForm(
            fullName,
            phoneNumber,
            email,
            city,
            district,
            ward,
            specific,
            addressType
        );
    }

    return false;
}

function submitShippingForm(
    fullName,
    phoneNumber,
    email,
    city,
    district,
    ward,
    specific,
    addressType
) {
    const csrfToken = document.querySelector('input[name="_token"]').value;
    $.ajax({
        url: "/add-shipping",
        method: "POST",
        data: {
            _token: csrfToken,
            fullName: fullName,
            phoneNumber: phoneNumber,
            email: email,
            city: city,
            district: district,
            ward: ward,
            specific: specific,
            addressType: addressType,
        },
        success: function (response) {
            if (response.success) {
                alert(response.message);
                window.location.reload();
            } else {
                alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        },
        error: function (response) {
            if (response.status === 401) {
                alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            } else {
                alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        },
    });
}

function showAllShippingModal() {
    $.ajax({
        url: "/get-all-shipping-by-customer-id", // Đường dẫn xử lý lấy danh sách shipping
        type: "GET",
        success: function (response) {
            // Xử lý dữ liệu từ server
            try {
                var shippings = response.shippings;

                // Hiển thị danh sách shipping trong modal
                var shippingListHtml = "";
                shippings.forEach(function (shipping) {
                    shippingListHtml +=
                        '<div class="mt-5 shipping-' +
                        shipping.shipping_id +
                        '" id="showAllShipping">' +
                        '<div class="d-flex">' +
                        '<h6 class="mr-2">' +
                        '<input type="radio" data-id="' +
                        shipping.shipping_id +
                        '" name="default-shipping" class="mb-1 select-shipping" ' +
                        (shipping.status === 1 ? "checked" : "") +
                        " /> | " +
                        shipping.fullname +
                        " | " +
                        shipping.phone_number +
                        " | ";
                    if (shipping.address_type === "HOME") {
                        shippingListHtml += "Nhà riêng | ";
                    }
                    if (shipping.address_type === "OFFICE") {
                        shippingListHtml += "Văn phòng | ";
                    }
                    shippingListHtml +=
                        '<i class="icon-delete" title="Xóa địa chỉ của bạn" onclick="removeShipping(' + shipping.shipping_id + ')"></i></div>';
                    if (shipping.status === 1) {
                        shippingListHtml +=
                            '<h6>Địa chỉ: <span class="text-danger">Mặc định</span></h6>';
                    }
                    shippingListHtml += "</h6>";
                    shippingListHtml +=
                        '<div class="d-flex justify-content-between">' +
                        '<div class="d-flex">' +
                        '<span class="mr-2">' +
                        shipping.address_specific +
                        " - " +
                        shipping.ward.ward_name +
                        ", " +
                        shipping.district.district_name +
                        ", " +
                        shipping.city.city_name +
                        "</span>" +
                        "</div>" +
                        "</div>" +
                        "</div>";
                });

                $("#all-shipping").html(shippingListHtml);
                $("#showAllShippingModal").show();
            } catch (error) {
                console.error("Error parsing shipping data:", error);
                // Xử lý lỗi khi không thể xử lý dữ liệu từ server
            }
        },
        error: function (xhr) {
            console.error("Error retrieving shipping list:", xhr.responseText);
            // Xử lý lỗi khi gọi AJAX không thành công
        },
    });
}

function closeShowAllShippingModal() {
    var modal = document.getElementById("showAllShippingModal");
    modal.style.display = "none";
}

function selectThisAddressAsTheDefaultAddress() {
    var idDefaultShipping = 0;
    // Lấy tất cả các input radio có thuộc tính name là 'default-shipping'
    var radioButtons = document.querySelectorAll(
        'input[name="default-shipping"]'
    );

    // Lặp qua từng input radio
    radioButtons.forEach(function (radioButton) {
        // Kiểm tra xem input radio này có được chọn hay không
        if (radioButton.checked) {
            // Lấy giá trị của thuộc tính data-id
            var dataId = radioButton.getAttribute("data-id");
            idDefaultShipping = dataId;
        }
    });
    if (idDefaultShipping !== 0) {
        changeThisAddressToDefaultInDB(idDefaultShipping);
    }
}

function changeThisAddressToDefaultInDB(idDefaultShipping) {
    const csrfToken = document.querySelector('input[name="_token"]').value;
    $.ajax({
        url: "/set-default-shipping",
        method: "POST",
        data: {
            idDefaultShipping: idDefaultShipping,
            _token: csrfToken,
        },
        success: function (response) {
            if (response.success) {
                alert("Địa chỉ mặc định đã được cập nhật.");
                window.location.reload();
                // Cập nhật giao diện người dùng nếu cần thiết
            } else {
                alert("Đã xảy ra lỗi. Vui lòng thử lại.");
            }
        },
        error: function (xhr, status, error) {
            console.error("Lỗi:", error);
            alert("Đã xảy ra lỗi. Vui lòng thử lại.");
        },
    });
}

function removeShipping(shippingId) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "/delete-shipping/" + shippingId,
        type: "DELETE",
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            if (response.success) {
                alert(response.message);
                // Xóa địa chỉ khỏi giao diện người dùng
                document.querySelector(".shipping-" + shippingId).remove();
            } else {
                alert(response.message);
            }
        },
        error: function (xhr, status, error) {
            alert("Không thể xóa địa chỉ này!");
        },
    });
}
