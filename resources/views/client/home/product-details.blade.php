@extends('client/layout-main')

@section('title', 'Trang Chủ')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="bread"><span><a href="/">Trang chủ</a></span> / <span>Chi tiết sản phẩm</span></p>
                </div>
            </div>
        </div>
    </div>


    <div class="colorlib-product">
        <div class="container">
            <div class="row row-pb-lg product-detail-wrap">
                <div class="col-sm-7">
                    <div class="owl-carousel">
                        <div class="item">
                            <div class="product-entry border">
                                <a href="#" class="prod-img">
                                    <img src="{{ asset('backend/images/product/' . $product->image) }}" id="src-img-large"
                                        class="img-fluid">
                                </a>
                            </div>
                        </div>
                        @foreach ($galleries as $gallery)
                            <div class="item">
                                <div class="product-entry border">
                                    <a href="#" class="prod-img">
                                        <img src="{{ asset('backend/images/gallery/' . $gallery->gallery_path) }}"
                                            class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        @foreach ($product->variants as $variant)
                            <div class="item">
                                <div class="product-entry border">
                                    <a href="#" class="prod-img">
                                        <img src="{{ asset('backend/images/option/' . $variant->image) }}"
                                            class="img-fluid">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-5">
                    <div class="product-desc">
                        <input type="hidden" value="{{ $product->product_id }}" id="product-id" />
                        <input type="hidden" value="{{ $product->name }}" id="product-name" />
                        <h3 class="mb-3">{{ $product->name }}</h3>
                        @if ($product->discount > 0)
                            <h6 class="text-danger mb-3">- {{ $product->discount }}%</h6>
                            @php
                                // Tính giá sau khi giảm giá
                                $minDiscountedPrice = $product->min_price * (1 - $product->discount / 100);
                                $maxDiscountedPrice = $product->max_price * (1 - $product->discount / 100);
                            @endphp
                            <h6><del id="price">
                                    {{ number_format($product->min_price, 0, ',', ',') }} VND -
                                    {{ number_format($product->max_price, 0, ',', ',') }} VND
                                </del></h6>
                            <h4><span id="price-discount">
                                    {{ number_format($minDiscountedPrice, 0, ',', ',') }} VND -
                                    {{ number_format($maxDiscountedPrice, 0, ',', ',') }} VND
                                </span></h4>
                        @else
                            <h4><span id="price-discount">
                                    {{ number_format($product->min_price, 0, ',', ',') }} VND -
                                    {{ number_format($product->max_price, 0, ',', ',') }} VND
                                </span></h4>
                        @endif
                        <span class="rate d-block mb-2">
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-full"></i>
                            <i class="icon-star-half"></i>
                            (0 đánh giá)
                        </span>
                        <div class="form-group">
                            <label for="size" class="mb-0">Kích thước:</label>
                            <select name="size" id="size" class="form-control" onchange="updateColor()">
                                <option value="">Chọn kích thước</option>
                                @foreach ($product->variants->unique('size_id') as $variant)
                                    <option value="{{ $variant->size_id }}">{{ $variant->size->name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" name="size_name" id="size_name">
                        </div>

                        <div class="form-group">
                            <label for="color" class="mb-0">Màu sắc:</label>
                            <select name="color" id="color" class="form-control" onchange="updatePriceAndImage()">
                                <option value="">Chọn màu sắc</option>
                            </select>
                            <input type="hidden" name="color_name" id="color_name">
                            <input type="hidden" name="image_variant" id="image_variant">
                            <input type="hidden" name="price_variant" id="price_variant">
                            <input type="hidden" name="discount" id="discount">
                            <input type="hidden" name="id_variant" id="id_variant">
                        </div>

                        <div class="input-group mb-4">
                            <span class="input-group-btn">
                                <button type="button" class="quantity-left-minus btn" data-type="minus" data-field="">
                                    <i class="icon-minus2"></i>
                                </button>
                            </span>
                            <input type="text" id="quantity" name="quantity" class="form-control input-number"
                                value="1" min="1" max="100">
                            <span class="input-group-btn ml-1">
                                <button type="button" class="quantity-right-plus btn" data-type="plus" data-field="">
                                    <i class="icon-plus2"></i>
                                </button>
                            </span>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <p class="addtocart"><a id="add-to-cart" class="btn btn-primary btn-addtocart"><i
                                            class="icon-shopping-cart"></i> Thêm vào giỏ hàng</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-md-12 pills">
                            <div class="bd-example bd-example-tabs">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">

                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-description-tab" data-toggle="pill"
                                            href="#pills-description" role="tab" aria-controls="pills-description"
                                            aria-expanded="true">Description</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-manufacturer-tab" data-toggle="pill"
                                            href="#pills-manufacturer" role="tab" aria-controls="pills-manufacturer"
                                            aria-expanded="true">Manufacturer</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-review-tab" data-toggle="pill"
                                            href="#pills-review" role="tab" aria-controls="pills-review"
                                            aria-expanded="true">Review</a>
                                    </li>
                                </ul>

                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane border fade show active" id="pills-description" role="tabpanel"
                                        aria-labelledby="pills-description-tab">
                                        {!! $product->description !!}
                                    </div>

                                    <div class="tab-pane border fade" id="pills-manufacturer" role="tabpanel"
                                        aria-labelledby="pills-manufacturer-tab">
                                        <p>Even the all-powerful Pointing has no control about the blind texts it is an
                                            almost unorthographic life One day however a small line of blind text by the
                                            name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                                        <p>When she reached the first hills of the Italic Mountains, she had a last view
                                            back on the skyline of her hometown Bookmarksgrove, the headline of Alphabet
                                            Village and the subline of her own road, the Line Lane. Pityful a rethoric
                                            question ran over her cheek, then she continued her way.</p>
                                    </div>

                                    <div class="tab-pane border fade" id="pills-review" role="tabpanel"
                                        aria-labelledby="pills-review-tab">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h3 class="head">23 Reviews</h3>
                                                <div class="review">
                                                    <div class="user-img"
                                                        style="background-image: url(images/person1.jpg)"></div>
                                                    <div class="desc">
                                                        <h4>
                                                            <span class="text-left">Jacob Webb</span>
                                                            <span class="text-right">14 March 2018</span>
                                                        </h4>
                                                        <p class="star">
                                                            <span>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-half"></i>
                                                                <i class="icon-star-empty"></i>
                                                            </span>
                                                            <span class="text-right"><a href="#" class="reply"><i
                                                                        class="icon-reply"></i></a></span>
                                                        </p>
                                                        <p>When she reached the first hills of the Italic Mountains, she had
                                                            a last view back on the skyline of her hometown Bookmarksgrov
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="review">
                                                    <div class="user-img"
                                                        style="background-image: url(images/person2.jpg)"></div>
                                                    <div class="desc">
                                                        <h4>
                                                            <span class="text-left">Jacob Webb</span>
                                                            <span class="text-right">14 March 2018</span>
                                                        </h4>
                                                        <p class="star">
                                                            <span>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-half"></i>
                                                                <i class="icon-star-empty"></i>
                                                            </span>
                                                            <span class="text-right"><a href="#" class="reply"><i
                                                                        class="icon-reply"></i></a></span>
                                                        </p>
                                                        <p>When she reached the first hills of the Italic Mountains, she had
                                                            a last view back on the skyline of her hometown Bookmarksgrov
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="review">
                                                    <div class="user-img"
                                                        style="background-image: url(images/person3.jpg)"></div>
                                                    <div class="desc">
                                                        <h4>
                                                            <span class="text-left">Jacob Webb</span>
                                                            <span class="text-right">14 March 2018</span>
                                                        </h4>
                                                        <p class="star">
                                                            <span>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-half"></i>
                                                                <i class="icon-star-empty"></i>
                                                            </span>
                                                            <span class="text-right"><a href="#" class="reply"><i
                                                                        class="icon-reply"></i></a></span>
                                                        </p>
                                                        <p>When she reached the first hills of the Italic Mountains, she had
                                                            a last view back on the skyline of her hometown Bookmarksgrov
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="rating-wrap">
                                                    <h3 class="head">Give a Review</h3>
                                                    <div class="wrap">
                                                        <p class="star">
                                                            <span>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                (98%)
                                                            </span>
                                                            <span>20 Reviews</span>
                                                        </p>
                                                        <p class="star">
                                                            <span>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-empty"></i>
                                                                (85%)
                                                            </span>
                                                            <span>10 Reviews</span>
                                                        </p>
                                                        <p class="star">
                                                            <span>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-empty"></i>
                                                                <i class="icon-star-empty"></i>
                                                                (70%)
                                                            </span>
                                                            <span>5 Reviews</span>
                                                        </p>
                                                        <p class="star">
                                                            <span>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-empty"></i>
                                                                <i class="icon-star-empty"></i>
                                                                <i class="icon-star-empty"></i>
                                                                (10%)
                                                            </span>
                                                            <span>0 Reviews</span>
                                                        </p>
                                                        <p class="star">
                                                            <span>
                                                                <i class="icon-star-full"></i>
                                                                <i class="icon-star-empty"></i>
                                                                <i class="icon-star-empty"></i>
                                                                <i class="icon-star-empty"></i>
                                                                <i class="icon-star-empty"></i>
                                                                (0%)
                                                            </span>
                                                            <span>0 Reviews</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const variants = @json($product->variants);

        function updateColor() {
            const sizeId = document.getElementById('size').value;
            const colorSelect = document.getElementById('color');

            // Clear existing options
            colorSelect.innerHTML = '<option value="">Chọn màu sắc</option>';

            if (sizeId) {
                const availableColors = variants.filter(variant => variant.size_id == sizeId);

                availableColors.forEach(variant => {
                    const option = document.createElement('option');
                    option.value = variant.color_id;
                    option.text = variant.color.name;
                    colorSelect.appendChild(option);
                });
            }
            // Clear the price when the color changes
            document.getElementById('quantity').value = 1;
            document.getElementById('price').innerText = '';
            document.getElementById('price-discount').innerText = '';
        }

        function updatePriceAndImage() {
            const colorId = document.getElementById('color').value;
            const sizeId = document.getElementById('size').value;

            if (colorId && sizeId) {
                const selectedVariant = variants.find(variant => variant.color_id == colorId && variant.size_id == sizeId);

                var imagePath = `{{ asset('backend/images/option/${selectedVariant.image}') }}`;
                document.getElementById('src-img-large').src = imagePath;

                const price = selectedVariant.price;
                const discount = {{ $product->discount }};
                const finalPrice = price - (price * discount / 100);
                const formattedPrice = new Intl.NumberFormat('en-US').format(price) +
                    ' VND';
                const formattedPriceDiscount = new Intl.NumberFormat('en-US').format(finalPrice) +
                    ' VND';
                if (discount > 0) {
                    document.getElementById('price').innerText = formattedPrice;
                }
                document.getElementById('price-discount').innerText = formattedPriceDiscount;
                document.getElementById('image_variant').value = selectedVariant.image;
                document.getElementById('price_variant').value = price;
                document.getElementById('discount').value = discount;
                document.getElementById('id_variant').value = selectedVariant.product_variant_id;
                document.getElementById('quantity').value = 1;
                document.getElementById('quantity').max = selectedVariant.quantity;
            } else {
                document.getElementById('price').innerText = '';
                document.getElementById('price-discount').innerText = '';
            }
        }
    </script>

@endsection
