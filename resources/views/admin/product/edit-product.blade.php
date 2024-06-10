@extends('admin/layout-main')

@section('title', 'Thêm Sản Phẩm')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">SỬA SẢN PHẨM</h1>
            <button type="submit" form="edit-product" class="button-add" title="Lưu sản phẩm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy"
                    viewBox="0 0 16 16">
                    <path d="M11 2H9v3h2z" />
                    <path
                        d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z" />
                </svg>
            </button>
        </div>

        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.update-product') }}" id="edit-product"
                            class="form-product" enctype="multipart/form-data" onsubmit="return validateFormProductAdd()">
                            @csrf

                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-one-tab" data-toggle="tab" href="#nav-one"
                                        role="tab" aria-controls="nav-one" aria-selected="true">Thông Tin Sản Phẩm</a>
                                    <a class="nav-item nav-link" id="nav-true-tab" data-toggle="tab" href="#nav-true"
                                        role="tab" aria-controls="nav-true" aria-selected="false">Liên Kết</a>
                                    <a class="nav-item nav-link" id="nav-three-tab" data-toggle="tab" href="#nav-three"
                                        role="tab" aria-controls="nav-three" aria-selected="false">Ảnh Gallery</a>
                                    <a class="nav-item nav-link" id="nav-for-tab" data-toggle="tab" href="#nav-for"
                                        role="tab" aria-controls="nav-for" aria-selected="false">Loại sản phẩm</a>
                                </div>
                            </nav>
                            <div class="tab-content pt-4" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-one" role="tabpanel"
                                    aria-labelledby="nav-one-tab">
                                    <input type="hidden" name="product_id" value="{{ $product->product_id }}" readonly>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="image">Ảnh sản phẩm (cũ)</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <img src="{{ asset('backend/images/product/' . $product->image) }}"
                                                class="img-thumbnail img-old" /></td>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="image">Ảnh sản phẩm (mới)
                                                <small class="d-block text-success">Chọn ảnh mới nếu bạn muốn thay đổi ảnh
                                                    thương hiệu</small>
                                            </label>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input"
                                                    id="customFile" onchange="previewImage(event)">
                                                <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                                            </div>
                                            <img class="img-thumbnail" id="imagePreview" src="#" alt="Ảnh xem trước">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="name">Tên sản phẩm</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="text" name="name" class="form-control" id="name"
                                                value="{{ $product->name }}"placeholder="Nhập tên sản phẩm">
                                            <small class="text-danger" id="nameError"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="description">Mô tả sản phẩm</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <textarea name="description" rows="8" class="form-control form-control-sm custom-input-form"
                                                value="{{ $product->description }}"id="productDescription">{{ $product->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="discount">Giảm giá (%)</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="text" name="discount" class="form-control" id="discount"
                                                value="{{ $product->discount }}" placeholder="Giảm giá(%)">
                                            <small class="text-danger" id="discountError"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="new">Sản phẩm mới</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="new" class="custom-control-input"
                                                    id="customCheck1" {{ $product->new ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck1"></label>
                                            </div>
                                            <small class="text-danger" id="newError"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="best-seller">Sản phẩm bán chạy</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="best-seller" class="custom-control-input"
                                                    id="customCheck2" {{ $product->best_seller ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck2"></label>
                                            </div>
                                            <small class="text-danger" id="bestSellerError"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="featured">Sản phẩm nổi bật</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="featured" class="custom-control-input"
                                                    id="customCheck3" {{ $product->featured ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="customCheck3"></label>
                                            </div>
                                            <small class="text-danger" id="featuredError"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="status">Trạng thái</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <select name="status" class="form-control" id="status">
                                                <option value="true" {{ $product->status == true ? 'selected' : '' }}>
                                                    Cho phép</option>
                                                <option value="false" {{ $product->status == false ? 'selected' : '' }}>
                                                    Không cho phép</option>
                                            </select>
                                            <small class="text-danger" id="statusError"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-true" role="tabpanel"
                                    aria-labelledby="nav-true-tab">
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="manufacturer_id">Nhà sản xuất</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <select id="manufacturer_id" name="manufacturer_id" class="form-control"
                                                required>
                                                <option value="">Chọn nhà sản xuất</option>
                                                @foreach ($manufacturers as $manufacturer)
                                                    <option value="{{ $manufacturer->manufacturer_id }}"
                                                        {{ $product->manufacturer_id == $manufacturer->manufacturer_id ? 'selected' : '' }}>
                                                        {{ $manufacturer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-danger" id="statusError"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="categories">Danh mục</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <div class="form-control checkbox-categories">
                                                @foreach ($categories as $category)
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="categories[]"
                                                            value="{{ $category->category_id }}"
                                                            class="custom-control-input"
                                                            id="category_{{ $category->category_id }}"
                                                            {{ $categoriesProduct->contains('category_id', $category->category_id) ? 'checked' : '' }}>
                                                        <label class="custom-control-label"
                                                            for="category_{{ $category->category_id }}">{{ $category->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-danger" id="statusError"></small>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-three" role="tabpanel"
                                    aria-labelledby="nav-three-tab">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="width: 20%">Hành động</th>
                                                <th>Ảnh</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($galleries as $gallery)
                                                <tr>
                                                    <td class="text-left"><a class="button-delete btn-delete-gallery"
                                                            data-toggle="tooltip" title="Gỡ bỏ">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-trash"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                                <path
                                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                            </svg>
                                                        </a></td>
                                                    <td class="text-left">
                                                        <input type="hidden" name="galleriesOld[]"
                                                            value={{ $gallery->gallery_path }} />
                                                        <img src="{{ asset('backend/images/gallery/' . $gallery->gallery_path) }}"
                                                            class="img-thumbnail gallery" />
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody id="galleryBody">
                                        </tbody>
                                        <tfoot>
                                            <th colspan="2">
                                                <a class="button-add" id="rowAdder" title="Thêm ảnh gallery">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                                    </svg>
                                                </a>
                                            </th>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="nav-for" role="tabpanel" aria-labelledby="nav-for-tab">
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">Hành động</th>
                                                <th>Hình Ảnh</th>
                                                <th>Màu Sắc</th>
                                                <th>Kích Thước</th>
                                                <th>Giá Tiền(VND)</th>
                                                <th>Số Lượng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($variants as $variant)
                                                <tr>
                                                    <td class="text-left"><a class="button-delete btn-delete-option"
                                                            data-toggle="tooltip" title="Gỡ bỏ">
                                                            <input type="hidden" name="optionIdOld[]"
                                                                value={{ $variant->product_variant_id }} />
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-trash"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                                <path
                                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                            </svg>
                                                        </a>
                                                    </td>
                                                    <td class="text-left">
                                                        <div class="form-group mb-0" style=" width: 130px;">
                                                            <input type="hidden" name="optionImageOld[]"
                                                                value={{ $variant->image }} />
                                                            <img class="img-thumbnail image-option"
                                                                src="{{ asset('backend/images/option/' . $variant->image) }}" />
                                                        </div>
                                                    </td>
                                                    <td class="text-left">
                                                        <div class="form-group" style=" width: 200px;">
                                                            <select name="optionColorOld[]" class="form-control"
                                                                id="color" required>
                                                                <option value="">Chọn màu sắc</option>
                                                                @foreach ($colors as $color)
                                                                    <option value="{{ $color->color_id }}"
                                                                        {{ $variant->color_id == $color->color_id ? 'selected' : '' }}>
                                                                        {{ $color->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="text-left">
                                                        <div class="form-group" style=" width: 200px;">
                                                            <select name="optionSizeOld[]" class="form-control"
                                                                id="size" required>
                                                                <option value="">Chọn kích thước</option>
                                                                @foreach ($sizes as $size)
                                                                    <option value="{{ $size->size_id }}"
                                                                        {{ $variant->size_id == $size->size_id ? 'selected' : '' }}>
                                                                        {{ $size->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="text-left">
                                                        <div class="form-group" style=" width: 200px;">
                                                            <input type="text" name="optionPriceOld[]"
                                                                value="{{ $variant->price }}" class="form-control"
                                                                id="optionPrice" pattern="^[0-9]+$"
                                                                title="Chỉ nhập số nguyên dương"
                                                                placeholder="Nhập giá tiền (VND)" required>
                                                        </div>
                                                    </td>
                                                    <td class="text-left">
                                                        <div class="form-group" style=" width: 200px;">
                                                            <input type="text" name="optionQuantityOld[]"
                                                                value="{{ $variant->quantity }}" class="form-control"
                                                                id="optionQuantity" pattern="^[0-9]+$"
                                                                title="Chỉ nhập số nguyên dương"
                                                                placeholder="Nhập số lượng" required>
                                                        </div>'
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tbody id="optionBody">
                                        </tbody>
                                        <tfoot>
                                            <th colspan="6">
                                                <a class="button-add" id="rowAdderOption" title="Thêm loại sản phẩm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                                    </svg>
                                                </a>
                                            </th>
                                        </tfoot>
                                    </table>
                                </div>
                                <div id="list-colors" data-colors='@json($colors)'></div>
                                <div id="list-sizes" data-colors='@json($sizes)'></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
