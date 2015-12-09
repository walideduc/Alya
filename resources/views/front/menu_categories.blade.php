 <div class="no-padding">
        <span class="title">CATEGORIES</span>
    </div>
    <div id="main_menu">
        <div class="list-group panel panel-cat">
            @foreach($categoriesLevel_1 as $categoryLevel_1)

                <a href="#sub{{$categoryLevel_1->id}}" class="list-group-item" data-toggle="collapse" data-parent="#main_menu">{{ucfirst(strtolower($categoryLevel_1->name))}}<i class="fa fa-caret-down pull-right"></i></a>

                <div class="collapse list-group-sub" id="sub{{$categoryLevel_1->id}}">
                    @foreach( $categoryLevel_1->children as $categoryLevel_2 )
                        <a href="#SubMenu{{$categoryLevel_2->id}}" class="list-group-item" data-toggle="collapse" data-parent="#SubMenu{{$categoryLevel_2->id}}">{{ucfirst(strtolower($categoryLevel_2->name))}}<i class="fa fa-caret-down"></i></a>

                        <div class="collapse list-group-submenu" id="SubMenu{{$categoryLevel_2->id}}">
                            @foreach( $categoryLevel_2->children as $categoryLevel_3 )
                                <a href="{{url('category/'.$categoryLevel_3->id.'_'.$categoryLevel_3->id)}}" class="list-group-item" >{{ucfirst(strtolower($categoryLevel_3->name))}}</a>

                                {{--<a href="#SubSubMenu{{$categoryLevel_3->id}}" class="list-group-item" data-toggle="collapse"--}}
                                   {{--data-parent="#SubSubMenu{{$categoryLevel_3->id}}">{{$categoryLevel_3->name}}<i class="fa fa-caret-down"></i></a>--}}

                                {{--<div class="collapse list-group-submenu list-group-submenu-{{$categoryLevel_3->id}}" id="SubSubMenu{{$categoryLevel_3->id}}">--}}
                                    {{--@foreach( $categoryLevel_3->children as $categoryLevel_4)--}}
                                        {{--@if($categoryLevel_4->name!=$categoryLevel_3->name)--}}
                                            {{--<a href="#" class="list-group-item" data-parent="#SubSubMenu1">{{$categoryLevel_4->name}}</a>--}}
                                        {{--@endif--}}
                                    {{--@endforeach--}}
                                {{--</div>--}}
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
