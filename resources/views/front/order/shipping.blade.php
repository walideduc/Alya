@extends('layouts.master')
@section('content')
    <div class="row">
        {{--<div class="col-lg-3 col-md-3 col-sm-12">--}}

        {{--<!-- RECENT PRODUCT -->--}}
        {{--<div class="col-lg-12 col-md-12 col-sm-12">--}}
        {{--<div class="no-padding">--}}
        {{--<span class="title">RECENT PRODUCT</span>--}}
        {{--</div>--}}
        {{--<div class="thumbnail col-lg-12 col-md-12 col-sm-6 text-center">--}}
        {{--<a href="detail.html" class="link-p">--}}
        {{--<img src="images/product-5.jpg" alt="">--}}
        {{--</a>--}}
        {{--<div class="caption prod-caption">--}}
        {{--<h4><a href="detail.html">Live Nation 3 Days of Peace and Music Carbon</a></h4>--}}
        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, minima!</p>--}}
        {{--<p>--}}
        {{--<div class="btn-group">--}}
        {{--<a href="#" class="btn btn-default">$ 428.96</a>--}}
        {{--<a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Buy</a>--}}
        {{--</div>--}}
        {{--</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="thumbnail col-lg-12 col-md-12 col-sm-6 visible-sm text-center">--}}
        {{--<a href="detail.html" class="link-p">--}}
        {{--<img src="images/product-6.jpg" alt="">--}}
        {{--</a>--}}
        {{--<div class="caption prod-caption">--}}
        {{--<h4><a href="detail.html">Live Nation ACDC Gray T-Shirt</a></h4>--}}
        {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut, minima!</p>--}}
        {{--<p>--}}
        {{--<div class="btn-group">--}}
        {{--<a href="#" class="btn btn-default">$ 428.96</a>--}}
        {{--<a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Buy</a>--}}
        {{--</div>--}}
        {{--</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<!-- End RECENT PRODUCT -->--}}

        {{--</div>--}}

        <div class="clearfix visible-sm"></div>

        <!-- Cart -->
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="col-lg-12 col-sm-12">
                <span class="title">CHECKOUT</span>
            </div>
            <div class="col-lg-12 col-sm-12 hero-feature">
                <!-- Trigger the modal with a button -->
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Ajouter une
                    adresse
                </button>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                     aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form role="form" action="{{route('order_shipping')}}">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <button type="button" class="close"
                                            data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">
                                        Modal title
                                    </h4>
                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body">
                                    {!! csrf_field() !!}
                                    @include('front.addressinfo')
                                    <button type="submit" class="btn btn-primary bottom">Ajouter</button>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <table class="table table-bordered tbl-cart">
                    <thead>
                    <tr>
                        <td>Product Name</td>
                        <td>Size</td>
                        <td>Color</td>
                        <td class="td-qty">Quantity</td>
                        <td>Unit Price</td>
                        <td>Sub Total</td>
                        <td>Action</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Age Of Wisdom Tan Graphic Tee</td>
                        <td>M</td>
                        <td>-</td>
                        <td class="text-center">1</td>
                        <td class="price">$ 122.21</td>
                        <td>$ 122.21</td>
                        <td class="text-center">
                            <a href="#" class="remove_cart" rel="2">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Adidas Men Red Printed T-shirt</td>
                        <td>S</td>
                        <td>Red</td>
                        <td class="text-center">2</td>
                        <td class="price">$ 20.63</td>
                        <td>$ 41.26</td>
                        <td class="text-center">
                            <a href="#" class="remove_cart" rel="1">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">Flat Shipping Rate</td>
                        <td class="total" colspan="2"><b>$ 5.00</b></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="right">Total</td>
                        <td class="total" colspan="2"><b>$ 168.47</b></td>
                    </tr>
                    </tbody>
                </table>
                <div class="btn-group btns-cart">
                    <button type="button" class="btn btn-primary">Continue</button>
                </div>

            </div>
        </div>
        <!-- End Cart -->


    </div>
@endsection



