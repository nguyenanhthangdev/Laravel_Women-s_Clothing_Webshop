@extends('admin/layout-main')

@section('title', 'Thêm Sản Phẩm')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">THÊM SẢN PHẨM</h1>
            <button type="submit" form="add-product" class="button-add" title="Lưu sản phẩm">
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
                        <form method="POST" action="{{ route('admin.save-product') }}" id="add-product"
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
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="image">Ảnh sản phẩm</label>
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
                                                placeholder="Nhập tên sản phẩm">
                                            <small class="text-danger" id="nameError"></small>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="description">Mô tả sản phẩm</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <textarea name="description" rows="8" class="form-control form-control-sm custom-input-form"
                                                id="productDescription"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-2">
                                            <label for="discount">Giảm giá (%)</label>
                                        </div>
                                        <div class="col-lg-10">
                                            <input type="text" name="discount" class="form-control" id="discount"
                                                value="0" placeholder="Giảm giá(%)">
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
                                                    id="customCheck1">
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
                                                    id="customCheck2">
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
                                                    id="customCheck3">
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
                                                <option value="true">Cho phép</option>
                                                <option value="false">Không cho phép</option>
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
                                                    <option value="{{ $manufacturer->manufacturer_id }}">
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
                                                            id="category_{{ $category->category_id }}">
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
                                        <tbody id="galleryBody">
                                            <!-- Các hàng trong bảng sẽ được thêm vào đây -->
                                        </tbody>
                                        <tfoot>
                                            <th colspan="2">
                                                <a class="button-add" id="rowAdder" title="Thêm ảnh gallery">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg"
                                                        viewBox="0 0 16 16">
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
                                        <tbody id="optionBody">
                                            <!-- Các hàng trong bảng sẽ được thêm vào đây -->
                                        </tbody>
                                        <tfoot>
                                            <th colspan="6">
                                                <a class="button-add" id="rowAdderOption" title="Thêm loại sản phẩm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg"
                                                        viewBox="0 0 16 16">
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
