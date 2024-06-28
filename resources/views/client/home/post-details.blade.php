@extends('client/layout-main')

@section('title', 'BÀI VIẾT')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="bread"><span><a href="/">Trang chủ</a></span> / <span>Bài viết</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        {!! $post->detail !!}
    </div>

@endsection
