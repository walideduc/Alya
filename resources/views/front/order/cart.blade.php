@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">

            <!-- Best Seller -->
            {{--@if(isset($bestseller))--}}
                {{--<div class="col-lg-12 col-md-12 col-sm-12">--}}
                    {{--<div class="no-padding">--}}
                        {{--<span class="title">BEST SELLER</span>--}}
                    {{--</div>--}}
                    {{--<div class="thumbnail col-lg-12 col-md-12 col-sm-6 text-center">--}}
                        {{--<a href="detail.html" class="link-p">--}}
                            {{--<img src="images/product-8.jpg" alt="">--}}
                        {{--</a>--}}
                        {{--<div class="caption prod-caption">--}}
                            {{--<h4><a href="detail.html">Penn State College T-Shirt</a></h4>--}}
                            {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, minima!</p>--}}
                            {{--<p>--}}
                            {{--<div class="btn-group">--}}
                                {{--<a href="#" class="btn btn-default">$ 528.96</a>--}}
                                {{--<a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Buy</a>--}}
                            {{--</div>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                    {{--<div class="thumbnail col-lg-12 col-md-12 col-sm-6 visible-sm text-center">--}}
                        {{--<a href="detail.html" class="link-p">--}}
                            {{--<img src="images/product-9.jpg" alt="">--}}
                        {{--</a>--}}
                        {{--<div class="caption prod-caption">--}}
                            {{--<h4><a href="detail.html">Ohio State College T-Shirt</a></h4>--}}
                            {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, minima!</p>--}}
                            {{--<p>--}}
                            {{--<div class="btn-group">--}}
                                {{--<a href="#" class="btn btn-default">$ 924.25</a>--}}
                                {{--<a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Buy</a>--}}
                            {{--</div>--}}
                            {{--</p>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--@endif--}}
            <!-- End Best Seller -->

        </div>

        <div class="clearfix visible-sm"></div>

        <!-- Cart -->
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="col-lg-12 col-sm-12">
                <span class="title">SHOPPING CART</span>
            </div>
            <div class="col-lg-12 col-sm-12 hero-feature">
                <table class="table table-bordered tbl-cart">
                    <thead>
                    <tr>
                        <td class="hidden-xs">Image</td>
                        <td>Product Name</td>
                        {{--<td>Size</td>--}}
                        {{--<td>Color</td>--}}
                        <td class="td-qty">Quantity</td>
                        <td>Unit Price</td>
                        <td>Sub Total</td>
                        <td>Remove</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( Cart::content() as $row )
                        <tr>
                            <td class="hidden-xs">
                                <a href="{{ route('product', [$row->product->slug_id]) }}">
                                    <img src="{{$row->product->image_url}}" alt="{{$row->product->name}}" title="" width="47" height="47" />
                                </a>
                            </td>
                            <td><a href="{{ route('product', [$row->product->slug_id]) }}">{{$row->product->name}}</a>
                            </td>
                            {{--<td>--}}
                                {{--<select name="">--}}
                                    {{--<option value="" selected="selected">S</option>--}}
                                    {{--<option value="">M</option>--}}
                                {{--</select>--}}
                            {{--</td>--}}
                            {{--<td>-</td>--}}
                            <td>
                                <input type="text" name="" value="{{ $row->qty }}" class="input-qty form-control text-center" />
                            </td>
                            <td class="price">{{ $row->price }} €</td>
                            <td>{{ $row->subtotal }} €</td>
                            <td class="text-center">
                                <a href="#" class="remove_cart" rel="2">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="4" align="right">Total</td>
                        <td class="total" colspan="2"><b>{{Cart::total() }} €</b>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn-group btns-cart">
                    <a href="{{route('home')}}" class="btn btn-primary" role="button">Continue mes achats <i class="fa fa-arrow-circle-right"></i></a>
                    <button type="button" class="btn btn-primary">Update Cart</button>
                    <a href="{{route('order_shipping')}}" class="btn btn-primary" role="button">Livraison <i class="fa fa-arrow-circle-right"></i></a>
                </div>

            </div>
        </div>
        <!-- End Cart -->


    </div>
@endsection



