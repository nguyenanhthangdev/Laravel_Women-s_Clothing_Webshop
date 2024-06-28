function showOrderCancelModal() {
    var modal = document.getElementById("showOrderCancelModal");
    modal.style.display = "block";
}

function closeOrderCancelModal() {
    var modal = document.getElementById("showOrderCancelModal");
    modal.style.display = "none";
}

$("#cancelOrderButton").click(function () {
    var orderCode = $("#order-code").val();
    var cancellationReason = $(
        'input[name="cancellation_reason"]:checked'
    ).val();
    if (!cancellationReason) {
        alert("Vui lòng chọn lý do hủy đơn hàng");
        return;
    }
    const csrfToken = document.querySelector('input[name="_token"]').value;
    $.ajax({
        url: "/admin/order-cancel",
        method: "POST",
        data: {
            _token: csrfToken,
            order_code: orderCode,
            cancellation_reason: cancellationReason,
        },
        success: function (response) {
            if (response.success) {
                alert(response.message);
                window.location.reload();
            } else {
                alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        },
        error: function () {
            alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");
        },
    });
});

$("#processOrderButton").click(function () {
    var orderCode = $(this).data("order_code");
    const csrfToken = document.querySelector('input[name="_token"]').value;
    $.ajax({
        url: "/admin/change-order-process",
        method: "POST",
        data: {
            _token: csrfToken,
            order_code: orderCode,
        },
        success: function (response) {
            if (response.success) {
                alert(response.message);
                window.location.reload();
            } else {
                alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        },
        error: function (xhr) {
            alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");
        },
    });
});

$("#shippedOrderButton").click(function () {
    var orderCode = $(this).data("order_code");
    const csrfToken = document.querySelector('input[name="_token"]').value;
    $.ajax({
        url: "/admin/change-order-shipped",
        method: "POST",
        data: {
            _token: csrfToken,
            order_code: orderCode,
        },
        success: function (response) {
            if (response.success) {
                alert(response.message);
                window.location.reload();
            } else {
                alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        },
        error: function (xhr) {
            alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");
        },
    });
});

$("#deliveredOrderButton").click(function () {
    var orderCode = $(this).data("order_code");
    const csrfToken = document.querySelector('input[name="_token"]').value;
    $.ajax({
        url: "/admin/change-order-delivered",
        method: "POST",
        data: {
            _token: csrfToken,
            order_code: orderCode,
        },
        success: function (response) {
            if (response.success) {
                alert(response.message);
                window.location.reload();
            } else {
                alert("Đã có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        },
        error: function (xhr) {
            alert("Đã xảy ra lỗi. Vui lòng thử lại sau.");
        },
    });
});