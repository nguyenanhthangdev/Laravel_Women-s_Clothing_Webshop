@extends('admin/layout-main')

@section('title', 'Thêm Danh Mục')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">CHỈNH SỬA DANH MỤC</h1>
            <button type="submit" form="edit-category" class="button-add" title="Chỉnh sửa danh mục">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy"
                    viewBox="0 0 16 16">
                    <path d="M11 2H9v3h2z" />
                    <path
                        d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z" />
                </svg>
            </button>
        </div>

        @if ($errors->has('error'))
            <div class="alert alert-danger text-center">
                {{ $errors->first('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.update-category') }}" id="edit-category"
                            class="form-category" enctype="multipart/form-data" onsubmit="return validateFormCategoryAdd()">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $category->category_id }}" readonly>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="image">Ảnh danh mục (cũ)</label>
                                </div>
                                <div class="col-lg-10">
                                    <img src="{{ asset('backend/images/category/' . $category->image) }}" width="100"
                                        height="100" class="img-thumbnail" /></td>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="image">Ảnh danh mục (mới)
                                        <small class="d-block text-success">Chọn ảnh mới nếu bạn muốn thay đổi ảnh danh
                                            mục</small>
                                    </label>
                                </div>
                                <div class="col-lg-10">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input" id="customFile"
                                            onchange="previewImage(event)">
                                        <label class="custom-file-label" for="customFile">Chọn ảnh</label>
                                    </div>
                                    <img class="img-thumbnail" id="imagePreview" src="#" alt="Ảnh xem trước">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="name">Tên danh mục</label>
                                </div>
                                <div class="col-lg-10">
                                    <input type="text" name="name" class="form-control" id="name"
                                        value="{{ $category->name }}" placeholder="Nhập tên danh mục">
                                    <small class="text-danger" id="nameError"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="featured">Tính nổi bật</label>
                                </div>
                                <div class="col-lg-10">
                                    <select name="featured" class="form-control" id="featured">
                                        <option value="true" {{ $category->featured == true ? 'selected' : '' }}>Nổi bật
                                        </option>
                                        <option value="false" {{ $category->featured == false ? 'selected' : '' }}>Không
                                            nổi bật</option>
                                    </select>
                                    <small class="text-danger" id="featuredError"></small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label for="status">Trạng thái</label>
                                </div>
                                <div class="col-lg-10">
                                    <select name="status" class="form-control" id="status">
                                        <option value="true" {{ $category->status == true ? 'selected' : '' }}>Cho phép
                                        </option>
                                        <option value="false" {{ $category->status == false ? 'selected' : '' }}>Không cho
                                            phép</option>
                                    </select>
                                    <small class="text-danger" id="statusError"></small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
