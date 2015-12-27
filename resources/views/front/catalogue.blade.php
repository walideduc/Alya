@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">

            <!-- Categories -->
            <div class="col-lg-12 col-md-12 col-sm-6">
                @include('front.menu_categories',['categoriesLevel_1'=>$categories])
            </div>
            <!-- End Categories -->

            <!-- Best Seller -->
            <div class="col-lg-12 col-md-12 col-sm-6">
                <div class="no-padding">
                    <span class="title">BEST SELLER</span>
                </div>
                <div class="hero-feature">
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
                <div class="hero-feature hidden-sm">
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
            </div>
            <!-- End Best Seller -->

        </div>

        <div class="clearfix visible-sm"></div>

        <!-- Catalogue -->
        <div class="col-lg-9 col-md-9 col-sm-12">
            {!! $products->render() !!}
            <div class="col-lg-12 col-sm-12">
                <span class="title">PRODUCTS CATALOGUE</span>
            </div>
            @foreach($products as $product)
                @include('front.productInfo', ['product'=>$product])
            @endforeach

            {!! $products->render() !!}

            {{--<div class="text-center">--}}
                {{--<ul class="pagination catalogue-pagination">--}}
                    {{--<li class="disabled"><a>First</a></li>--}}
                    {{--<li class="disabled"><a>Prev</a></li>--}}
                    {{--<li class="active"><a href="#">1</a></li>--}}
                    {{--<li><a href="#">2</a></li>--}}
                    {{--<li><a href="#">3</a></li>--}}
                    {{--<li><a href="#">4</a></li>--}}
                    {{--<li><a href="#">Next</a></li>--}}
                    {{--<li><a href="#">Last</a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
        <!-- End Catalogue -->


    </div>
@endsection