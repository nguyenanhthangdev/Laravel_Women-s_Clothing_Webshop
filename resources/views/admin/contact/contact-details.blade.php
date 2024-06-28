@extends('admin/layout-main')

@section('title', 'Phản Hồi')

@section('content')
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">CHI TIẾT PHẢN HỒI</h1>
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
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label for="name">Tiêu đề</label>
                            </div>
                            <div class="col-lg-10">
                                <h3>{{ $contact->title }}</h3>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label for="name">Nội dung</label>
                            </div>
                            <div class="col-lg-10">
                                <p>{{ $contact->detail }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label for="name">Người gửi</label>
                            </div>
                            <div class="col-lg-10">
                                <p>{{ $contact->name }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label for="name">Email</label>
                            </div>
                            <div class="col-lg-10">
                                <p>{{ $contact->email }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label for="name">Số điện thoại</label>
                            </div>
                            <div class="col-lg-10">
                                <p>{{ $contact->phone }}</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-2">
                                <label for="name">Ngày gửi</label>
                            </div>
                            <div class="col-lg-10">
                                <p>{{ $contact->created_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
