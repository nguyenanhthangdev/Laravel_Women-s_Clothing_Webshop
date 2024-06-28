function previewImage(event) {
    const fileInput = event.target;
    const file = fileInput.files[0];

    const imagePreview = document.getElementById("imagePreview");

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = "block";
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.src = "#";
        imagePreview.style.display = "none";
    }
}

function previewGalleryImage(event, row) {
    const input = event.target;
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById("galleryPreview" + row);
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
}

function previewOptionImage(event, row) {
    const input = event.target;
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById("optionImagePreview" + row);
            preview.src = e.target.result;
            preview.style.display = "block";
        };
        reader.readAsDataURL(file);
    }
}

ClassicEditor.create(document.querySelector("#productDescription")).catch(
    (error) => {
        console.error(error);
    }
);

ClassicEditor.create(document.querySelector("#detail")).catch((error) => {
    console.error(error);
});

var gallery_row = 0;
$("#rowAdder").click(function () {
    gallery_row++;
    html = '<tr id="gallery-row' + gallery_row + '">';
    html +=
        '<td  class="text-left"><a class="button-delete" onclick="$(\'#gallery-row' +
        gallery_row +
        '\').remove();" data-toggle="tooltip" title="Gỡ bỏ">';
    html +=
        '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">';
    html +=
        '<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />';
    html +=
        '<path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />';
    html += "</svg>";
    html += "</a></td>";
    html += '<td class="text-left">';
    html +=
        '<input type="file" name="gallery[]" class="d-block gallery-' +
        gallery_row +
        '" onchange="previewGalleryImage(event, ' +
        gallery_row +
        ')" />';
    html +=
        '<img class="img-thumbnail gallery-preview mt-2" id="galleryPreview' +
        gallery_row +
        '" src="#" alt="Ảnh xem trước">';
    html += "</td>";
    html += "</tr>";
    $("#galleryBody").append(html);
});

$("body").on("click", ".btn-delete-gallery", function () {
    $(this).closest("tr").remove();
});

$("body").on("click", ".btn-delete-option", function () {
    $(this).closest("tr").remove();
});
