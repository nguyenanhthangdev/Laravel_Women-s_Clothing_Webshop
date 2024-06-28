// function confirmUserDelete(user_id) {
//     Swal.fire({
//         title: 'XÓA NHÂN VIÊN',
//         text: "Bạn có chắc chắn muốn xóa?",
//         icon: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#15a362',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Xóa',
//         cancelButtonText: 'Hủy'
//     }).then((result) => {
//         if (result.isConfirmed) {
//             // Lấy CSRF token từ meta tag
//             const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

//             // Gửi yêu cầu xóa bằng AJAX
//             $.ajax({
//                 url: '/admin/delete-user/' + user_id,
//                 type: 'get',
//                 headers: {
//                     'X-CSRF-TOKEN': csrfToken
//                 }
//             });
//         }
//     });
// }

function confirmUserDelete(user_id) {
    Swal.fire({
        title: 'XÓA NHÂN VIÊN',
        text: "Bạn có chắc chắn muốn xóa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/delete-user/' + user_id;
        }
    });
}

function confirmManufacturerDelete(manufacturer_id) {
    Swal.fire({
        title: 'XÓA THƯƠNG HIỆU',
        text: "Bạn có chắc chắn muốn xóa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/delete-manufacturer/' + manufacturer_id;
        }
    });
}

function confirmCategoryDelete(category_id) {
    Swal.fire({
        title: 'XÓA DANH MỤC',
        text: "Bạn có chắc chắn muốn xóa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/delete-category/' + category_id;
        }
    });
}

function confirmSizeDelete(size_id) {
    Swal.fire({
        title: 'XÓA KÍCH THƯỚC',
        text: "Bạn có chắc chắn muốn xóa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/delete-size/' + size_id;
        }
    });
}

function confirmColorDelete(color_id) {
    Swal.fire({
        title: 'XÓA MÀU SẮC',
        text: "Bạn có chắc chắn muốn xóa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/delete-color/' + color_id;
        }
    });
}

function confirmProductDelete(product_id) {
    Swal.fire({
        title: 'XÓA SẢN PHẨM',
        text: "Bạn có chắc chắn muốn xóa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/delete-product/' + product_id;
        }
    });
}

function confirmBannerDelete(banner_id) {
    Swal.fire({
        title: 'XÓA ẢNH BANNER',
        text: "Bạn có chắc chắn muốn xóa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/delete-banner/' + banner_id;
        }
    });
}

function confirmOrderCancel(order_code) {
    Swal.fire({
        title: 'HỦY ĐƠN HÀNG',
        text: "Bạn có chắc chắn muốn hủy đơn hàng?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/order-cancel/' + order_code;
        }
    });
}

function confirmPostDelete(post_id) {
    Swal.fire({
        title: 'XÓA BÀI VIẾT',
        text: "Bạn có chắc chắn muốn xóa?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15a362',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/admin/delete-post/' + post_id;
        }
    });
}