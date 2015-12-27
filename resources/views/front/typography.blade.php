@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-12">

            <!-- RECENT PRODUCT -->
            <div class="col-lg-12 col-md-12 col-sm-12 visible-lg visible-md">
                <div class="no-padding">
                    <span class="title">RECENT PRODUCT</span>
                </div>
                <div class="thumbnail col-lg-12 col-md-12 col-sm-6 visible-lg visible-md text-center">
                    <a href="detail.html" class="link-p">
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
            <!-- End RECENT PRODUCT -->

        </div>

        <div class="clearfix visible-sm"></div>

        <!-- Cart -->
        <div class="col-lg-9 col-md-9 col-sm-12">
            <div class="col-lg-12 col-sm-12">
                <span class="title">TYPOGRAPHY</span>
            </div>
            <div class="col-lg-12 col-sm-12 hero-feature">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                </p>
                <h1>h1. Heading 1</h1>
                <h2>h2. Heading 2</h2>
                <h3>h3. Heading 3</h3>
                <h4>h4. Heading 4</h4>
                <h5>h5. Heading 5</h5>
                <h6>h6. Heading 6</h6>
                <p>
                <ul>
                    <li>Unordered List Item # 1</li>
                    <li><small>List Item in small tag</small></li>
                    <li><strong>List Item in bold tag</strong></li>
                    <li><em>List Item in italics tag</em></li>
                    <li>Unordered List Item which is a longer item and may break into more lines.</li>
                    <li><strong>List Item in strong tag</strong></li>
                    <li><em>List Item in emphasis tag</em></li>
                </ul>
                </p>
                <p>
                <ol>
                    <li>Ordered List Item # 1</li>
                    <li>.text-info Ordered List Item</li>
                    <li>.text-error Ordered List Item</li>
                    <li><strong>.text-success</strong>&nbsp;Ordered List Item</li>
                    <li>.text-warning Ordered List Item</li>
                    <li>.muted Ordered List Item</li>
                </ol>
                </p>
                <blockquote>
                    <p>blockquote Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                </blockquote>
                <hr />
                <p><a href="#">Link</a></p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum, sit aliquid iusto quis suscipit architecto voluptatem illum enim deserunt expedita.</p>
            </div>
        </div>
        <!-- End Cart -->


    </div>
@endsection



