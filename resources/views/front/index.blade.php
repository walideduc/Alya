@extends('layouts.default')

@section('content')
    <div class="row">

        <!-- Slider -->
        <div class="col-lg-12 col-md-12">
            <div class="slider">
                <ul class="bxslider">
                    <li>
                        <a href="index.html">
                            <img src="images/puericulture-jouets-ok.jpg" alt=""/>
                        </a>
                    </li>
                    <li>
                        <a href="index.html">
                            <img src="images/son-image-gps-ok.jpg" alt=""/>
                        </a>
                    </li>
                    <li>
                        <a href="index.html">
                            <img src="images/telephonie-ok.jpg" alt=""/>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Slider -->

        <!-- Product Selection, visible only on large desktop -->
        <!-- <div class="col-lg-3 visible-lg">
            <div class="row text-center">
                <div class="col-lg-12 col-md-12 hero-feature">
                    <div class="thumbnail">
                        <a href="detail.html" class="link-p first-p">
                            <img src="images/product-1.jpg" alt="">
                        </a>
                        <div class="caption prod-caption">
                            <h4><a href="detail.html">Funkalicious Print T-Shirt</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, minima!</p>
                            <p>
                            <div class="btn-group">
                                <a href="#" class="btn btn-default">$ 928.96</a>
                                <a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Buy</a>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- End Product Selection -->
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">

            <!-- Categories -->
                @include('front.menu_categories',['categoriesLevel_1'=>$categories])
            <!-- End Categories -->

            <!-- Best Seller -->
            <div class="col-lg-12 col-md-12 col-sm-6">
                <div class="no-padding">
                    <span class="title">BEST SELLER</span>
                </div>
                <div class="hero-feature">
                    <div class="thumbnail text-center">
                        <a href="detail.html" class="link-p">
                            <img src="images/product-8.jpg" alt="">
                        </a>
                        <div class="caption prod-caption">
                            <h4><a href="detail.html">Penn State College T-Shirt</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, minima!</p>
                            <p>
                            <div class="btn-group">
                                <a href="#" class="btn btn-default">$ 528.96</a>
                                <a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Buy</a>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="hero-feature hidden-sm">
                    <div class="thumbnail text-center">
                        <a href="detail.html" class="link-p">
                            <img src="images/product-9.jpg" alt="">
                        </a>
                        <div class="caption prod-caption">
                            <h4><a href="detail.html">Ohio State College T-Shirt</a></h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, minima!</p>
                            <p>
                            <div class="btn-group">
                                <a href="#" class="btn btn-default">$ 924.25</a>
                                <a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Buy</a>
                            </div>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Best Seller -->

        </div>

        @foreach( $categories_products as $category_products)
            <div class="clearfix visible-sm"></div>

            <!-- Adidas Category -->
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="col-lg-12 col-sm-12">
                    <span class="title">{{$category_products['category']}}</span>
                </div>
                 @foreach( $category_products['products'] as $product)
                    @include('front.productInfo', ['product'=>$product])
                 @endforeach
            </div>
            <!-- End Adidas Category -->
        @endforeach
    </div>
@endsection