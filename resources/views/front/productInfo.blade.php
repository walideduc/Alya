<div class="col-lg-4 col-sm-4 hero-feature text-center">
    <div class="thumbnail">
        <a href= "{{ route('product', [$product->slug_id]) }}"  class="link-p">
            <img src="{{$product->image_url}}"  alt="">
        </a>
        <div class="caption prod-caption">
            <h4><a href="{{ route('product', [$product->slug_id]) }}" >{{$product->name}}</a></h4>
            <a style="color:black;background-color: transparent;text-decoration:none;" href="{{ route('product', [$product->slug_id]) }}" ><p>{{str_limit($product->description,20).' lire plus'}}</p></a>
            <p>
            <div class="btn-group">
                <a href="#" class="btn btn-default"> {{$product->price}} </a>
                <a href="#" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Ajout </a>
            </div>
            </p>
        </div>
    </div>
</div>