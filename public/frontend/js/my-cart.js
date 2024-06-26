document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("add-to-cart")
        .addEventListener("click", function (e) {
            e.preventDefault();

            const productId = document.getElementById("product-id").value;
            const colorId = document.getElementById("color").value;
            const colorName = document.getElementById("color_name").value;
            const sizeId = document.getElementById("size").value;
            const sizeName = document.getElementById("size_name").value;
            const quantity = document.getElementById("quantity").value;
            const imageVariant = document.getElementById("image_variant").value;
            const priceVariant = document.getElementById("price_variant").value;
            const discount = document.getElementById("discount").value;
            const variantId = document.getElementById("id_variant").value;
            const productName = document.getElementById("product-name").value;

            const data = {
                product_id: productId,
                color_id: colorId,
                color_name: colorName,
                size_id: sizeId,
                size_name: sizeName,
                quantity: quantity,
                image_variant: imageVariant,
                price_variant: priceVariant,
                discount: discount,
                variant_id: variantId,
                product_name: productName,
                _token: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            };

            fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(data),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert("Đã thêm sản phẩm vào giỏ hàng");
                        document.querySelector(".cart span").innerText =
                            data.cartCount;
                    } else {
                        alert("Failed to add product to cart.");
                    }
                })
                .catch((error) => console.error("Error:", error));
        });
});

document.getElementById("color").addEventListener("change", function () {
    var colorName = this.options[this.selectedIndex].text;
    document.getElementById("color_name").value = colorName;
});

document.getElementById("size").addEventListener("change", function () {
    var sizeName = this.options[this.selectedIndex].text;
    document.getElementById("size_name").value = sizeName;
});

function removeFromCart(variantId) {
    fetch("/cart/remove", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ variant_id: variantId }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                alert(data.message);
                document.getElementById("cart-item-" + variantId).remove();
                document.querySelector(".cart span").innerText = data.cartCount;
                updateTotalPrice();

                if (data.cartCount == 0) {
                    document.getElementById("cart-table").style.display =
                        "none";
                    document.getElementById("cart-empty").style.display =
                        "block";
                }
            } else {
                alert("Lỗi khi xóa sản phẩm khỏi giỏ hàng.");
            }
        })
        .catch((error) => console.error("Error:", error));
}

function updateCart(variantId, quantity) {
    const csrfToken = document.querySelector('input[name="_token"]').value;
    $.ajax({
        url: "/cart/update-cart",
        method: "POST",
        data: {
            variant_id: variantId,
            quantity: quantity,
            _token: csrfToken,
        },
        success: function (response) {
            updateCartItemPrice(variantId, quantity);
            updateTotalPrice();
        },
        error: function (xhr, status, error) {
            alert("Đã có lỗi xảy ra. Vui lòng thử lại sau!");
        },
    });
}

function updateCartItemPrice(variantId, quantity) {
    var quantityInput = document.getElementById("quantity-" + variantId);
    var priceInput = document.getElementById("price-" + variantId).value;
    var discountInput = document.getElementById("discount-" + variantId).value;

    quantity = parseInt(quantity);
    var price = parseInt(priceInput);
    var discount = parseInt(discountInput);

    var total = (price - (price * discount) / 100) * quantity;
    document.getElementById("total-" + variantId).innerText =
        total.toLocaleString() + " VND";
    quantityInput.value = quantity;
}

function updateTotalPrice() {
    var totalPrice = 0;
    $(".quantity-cart").each(function () {
        var variantId = $(this).attr("id").split("-")[1];
        var quantity = $(this).val();
        var priceVariant = $("#price-" + variantId).val();
        var discount = $("#discount-" + variantId).val();
        var itemTotal =
            (priceVariant - (priceVariant * discount) / 100) * quantity;
        totalPrice += itemTotal;
    });
    document.getElementById("total-price").innerText =
        totalPrice.toLocaleString() + " VND";
    document.getElementById("total-of-all-prices").innerText =
        totalPrice.toLocaleString() + " VND";
}

function increaseQuantity(variantId) {
    var quantityInput = document.getElementById("quantity-" + variantId);
    var currentQuantity = parseInt(quantityInput.value);
    currentQuantity++;
    updateCart(variantId, currentQuantity);
}

function decreaseQuantity(variantId) {
    var quantityInput = document.getElementById("quantity-" + variantId);
    var currentQuantity = parseInt(quantityInput.value);
    if (currentQuantity > 1) {
        currentQuantity--;
        updateCart(variantId, currentQuantity);
    }
}
