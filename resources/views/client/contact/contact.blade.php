@extends('client/layout-main')

@section('title', 'Trang Chủ')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="bread"><span><a href="/">Trang chủ</a></span> / <span>Liên hệ</span></p>
                </div>
            </div>
        </div>
    </div>


    <div id="colorlib-contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h3>THÔNG TIN LIÊN HỆ</h3>
                    <div class="row contact-info-wrap">
                        <div class="col-md-3">
                            <p><span><i class="icon-location"></i></span>15/188 Đường Hồ Tùng Mậu, Nam Từ Liêm</p>
                        </div>
                        <div class="col-md-3">
                            <p><span><i class="icon-phone3"></i></span>+ 1235 2355 98</p>
                        </div>
                        <div class="col-md-3">
                            <p><span><i class="icon-paperplane"></i></span>havana@gmail.com</p>
                        </div>
                        <div class="col-md-3">
                            <p><span><i class="icon-globe"></i></span>havana.com</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-wrap">
                        <h3>Liên hệ</h3>
                        <form class="contact-form" onsubmit="return validateContact()">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="fullName">Họ tên</label>
                                        <input type="text" id="fullName" name="fullName" class="form-control" />
                                        <small class="text-danger" id="fullNameError"></small>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" id="email" name="email" class="form-control" />
                                        <small class="text-danger" id="emailError"></small>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="phoneNumber">Số điện thoại</label>
                                        <input type="text" id="phoneNumber" name="phoneNumber" class="form-control" />
                                        <small class="text-danger" id="phoneNumberError"></small>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Tiêu đề</label>
                                        <input type="text" id="title" name="title" class="form-control" />
                                        <small class="text-danger" id="titleError"></small>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="detail">Nội dung</label>
                                        <textarea name="detail" id="detail" cols="30" rows="10" class="form-control"></textarea>
                                        <small class="text-danger" id="detailError"></small>
                                    </div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="submit" value="Gửi" class="btn btn-primary" id="send-contact">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="map" class="colorlib-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.8803598727623!2d105.77246711176139!3d21.03747258053324!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313454b61ea47963%3A0x34eb9c34d58cf6a1!2zMTAgxJAuIEjhu5MgVMO5bmcgTeG6rXUsIE1haSBE4buLY2gsIEPhuqd1IEdp4bqleSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1711286981303!5m2!1svi!2s"
                            width="600" height="500" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
