function fetchDistricts() {
    var cityId = document.getElementById("city").value;

    if (cityId) {
        $.ajax({
            url: '/get-districts/' + cityId,
            type: 'GET',
            success: function(data) {
                var districtSelect = document.getElementById("district");
                districtSelect.innerHTML = '<option value="">Chọn quận huyện</option>';

                data.forEach(function(district) {
                    var option = document.createElement("option");
                    option.value = district.district_id;
                    option.text = district.district_name;
                    districtSelect.appendChild(option);
                });
                
                document.getElementById("ward").innerHTML = '<option value="">Chọn xã phường</option>';
            },
            error: function(xhr, status, error) {
                console.error("Đã xảy ra lỗi:", error);
            }
        });
    } else {
        document.getElementById("district").innerHTML = '<option value="">Chọn quận huyện</option>';
        document.getElementById("ward").innerHTML = '<option value="">Chọn xã phường</option>';
    }
}

function fetchWards() {
    var districtId = document.getElementById("district").value;

    if (districtId) {
        $.ajax({
            url: '/get-wards/' + districtId,
            type: 'GET',
            success: function(data) {
                var wardSelect = document.getElementById("ward");
                wardSelect.innerHTML = '<option value="">Chọn xã phường</option>';

                data.forEach(function(ward) {
                    var option = document.createElement("option");
                    option.value = ward.ward_id;
                    option.text = ward.ward_name;
                    wardSelect.appendChild(option);
                });
            },
            error: function(xhr, status, error) {
                console.error("Đã xảy ra lỗi:", error);
            }
        });
    } else {
        document.getElementById("ward").innerHTML = '<option value="">Chọn xã phường</option>';
    }
}