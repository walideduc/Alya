@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">

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
            <div class="col-lg-12 col-sm-12">
                <span class="title">PRODUCT COMPARISON</span>
            </div>
            <table class="table table-bordered comparison">
                <thead>
                <tr>
                    <td class="compare-product" colspan="5">Product Details</td>
                </tr>
                </thead>
                <tbody>
                <tr class="first_row">
                    <td>Product</td>
                    <td>Age Of Wisdom Tan Graphic Tee</td>
                    <td>Classic Laundry Green Graphic T-Shirt</td>
                    <td>Disc Jockey Print T-Shirt</td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>
                        <div class="thumbnail">
                            <img src="images/product-2-small.jpg" alt="product image">
                        </div>
                    </td>
                    <td>
                        <div class="thumbnail">
                            <img src="images/product-3-small.jpg" alt="product image">
                        </div>
                    </td>
                    <td>
                        <div class="thumbnail">
                            <img src="images/product-4-small.jpg" alt="product image">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>$122.51</td>
                    <td>$628.96</td>
                    <td>$394.64</td>
                </tr>
                <tr>
                    <td>Model</td>
                    <td>Lorem</td>
                    <td>ipsum</td>
                    <td>dolor</td>
                </tr>
                <tr>
                    <td>Brand</td>
                    <td>consectetur</td>
                    <td>adipisicing</td>
                    <td>incididunt</td>
                </tr>
                <tr>
                    <td>Availability</td>
                    <td>In Stock</td>
                    <td>In Stock</td>
                    <td>In Stock</td>
                </tr>
                <tr>
                    <td>Rating</td>
                    <td>
                        <div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                    </td>
                    <td>
                        <div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </td>
                    <td>
                        <div class="product-rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Summary</td>
                    <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
                    <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
                    <td>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</td>
                </tr>
                <tr>
                    <td></td>
                    <td><button class="btn btn-sm btn-warning">Add To Cart</button></td>
                    <td><button class="btn btn-sm btn-warning">Add To Cart</button></td>
                    <td><button class="btn btn-sm btn-warning">Add To Cart</button></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button class="btn btn-sm btn-danger"><i class="fa fa-remove"></i> Remove</button></td>
                    <td><button class="btn btn-sm btn-danger"><i class="fa fa-remove"></i> Remove</button></td>
                    <td><button class="btn btn-sm btn-danger"><i class="fa fa-remove"></i> Remove</button></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- End Catalogue -->


    </div>
@endsection



