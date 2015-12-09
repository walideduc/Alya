@extends('layouts.master')

@section('title', 'Page Title')
Hello {{ $name }} <br/>
{{ time() }} <br/>
Hello, @{{ name }}.<br/>
Hello, {{ $variable_not_set or 'Default'}}.<br/>
Hello, {!! "<b> $name </b>" !!}.<br/>

@unless (Auth::check())
    You are not signed in..<br/>
@endunless


@if (count($records) === 1)
    I have one record!.<br/>
@elseif (count($records) > 1)
    I have multiple records!.<br/>
@else
    I don't have any records!.<br/>
@endif

@for ($i = 0; $i < 3; $i++)
    <p> The current value is {{ $i }}</p>
@endfor


@inject('cdiscountPro', 'alyya\Partners\Suppliers\CdiscountPro\CdiscountPro')

<div>
    Monthly Revenue: {{ dd($cdiscountPro) }}.
</div>

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <p>This is my body content.</p>
@endsection



{{-- unlike HTML comments, Blade comments are not included in the HTML returned by your application --}}
{{-- Even though the included view will inherit all data available in the parent view, you may also pass an array of extra data to the included view: --}}
{{-- @include('view.name', ['some' => 'data']) --}}
{{--
Note: You should avoid using the __DIR__ and __FILE__ constants in your Blade views, since they will refer to the location of the cached view.
 --}}


{{--
@each('view.name', $jobs, 'job')
@each('view.name', $jobs, 'job', 'view.empty')

 --}}

{{-- The @ inject directive may be used to retrieve a service from the Laravel service container. --}}