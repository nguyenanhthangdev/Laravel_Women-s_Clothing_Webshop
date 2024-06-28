$("#stars i").on("click", function () {
    var rating = $(this).data("value");
    $("#rating").val(rating);

    // Reset all stars
    $("#stars i").removeClass("icon-star-full").addClass("icon-star-empty");

    // Highlight the selected stars
    $("#stars i").each(function (index) {
        if (index < rating) {
            $(this).removeClass("icon-star-empty").addClass("icon-star-full");
        }
    });
});

$("#reviewForm").on("submit", function (e) {
    e.preventDefault();

    const isLoggedIn =
        document.querySelector('meta[name="user-logged-in"]').content ===
        "true";

    // Kiểm tra xem người dùng đã đăng nhập hay chưa
    if (!isLoggedIn) {
        alert("Vui lòng đăng nhập để đánh giá sản phẩm.");
        return;
    }

    var rating = $("#rating").val();
    var comment = $("#comment").val().trim();

    // Kiểm tra xem người dùng đã chọn sao và nhập comment hay chưa
    if (rating == 0) {
        alert("Vui lòng chọn số sao để đánh giá.");
        return;
    }

    if (comment == "") {
        alert("Vui lòng nhập đánh giá của bạn.");
        return;
    }

    const productId = document.getElementById("product-id").value;

    var formData = {
        _token: $('input[name="_token"]').val(),
        rating: rating,
        comment: comment,
    };

    $.ajax({
        url: '/add-review/' + productId,
        method: "POST",
        data: formData,
        success: function (response) {
            if (response.success) {
                alert("Đánh giá của bạn đã được gửi thành công.");
                location.reload();
            } else {
                alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        },
        error: function () {
            alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");
        },
    });
});
