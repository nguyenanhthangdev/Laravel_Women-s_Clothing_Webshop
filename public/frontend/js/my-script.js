$(document).ready(function () {
    $(".quantity-right-plus").click(function (e) {
        e.preventDefault();

        const quantityInput = document.getElementById("quantity");
        let quantity = parseInt(quantityInput.value);
        const maxQuantity = parseInt(quantityInput.max);

        if (quantity < maxQuantity) {
            quantityInput.value = quantity + 1;
        }
    });

    $(".quantity-left-minus").click(function (e) {
        e.preventDefault();

        const quantityInput = document.getElementById("quantity");
        let quantity = parseInt(quantityInput.value);

        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    });
});