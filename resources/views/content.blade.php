@extends('admin::index', ['header' => strip_tags($header)])

@section('breadcrumb')
    <!-- breadcrumb start -->
    @if ($breadcrumb)
        <li class="nav-item">
            <a href="{{ admin_url('/') }}" class="nav-link" data-lte-toggle="sidebar" role="button"><i
                        class="fa fa-dashboard"></i> {{__('Home')}}</a></li>
        @foreach($breadcrumb as $item)
            @if($loop->last)
                <li class="nav-item active">
                    @if (\Illuminate\Support\Arr::has($item, 'icon'))
                        <i class="fa fa-{{ $item['icon'] }}"></i>
                    @endif
                    {{ $item['text'] }}
                </li>
            @else
                <li class="nav-item">
                    @if (\Illuminate\Support\Arr::has($item, 'url'))
                        <a href="{{ admin_url(\Illuminate\Support\Arr::get($item, 'url')) }}" class="nav-link"
                           data-lte-toggle="sidebar" role="button">
                            @if (\Illuminate\Support\Arr::has($item, 'icon'))
                                <i class="fa fa-{{ $item['icon'] }}"></i>
                            @endif
                            {{ $item['text'] }}
                        </a>
                    @else
                        @if (\Illuminate\Support\Arr::has($item, 'icon'))
                            <i class="fa fa-{{ $item['icon'] }}"></i>
                        @endif
                        {{ $item['text'] }}
                    @endif
                </li>
            @endif
        @endforeach
    @elseif(config('admin.enable_default_breadcrumb'))
        <li class="nav-item">
            <a href="{{ admin_url('/') }}" class="nav-link" data-lte-toggle="sidebar" role="button"><i
                        class="fa fa-dashboard"></i> {{__('Home')}}</a>
        </li>
        @for($i = 2; $i <= count(Request::segments()); $i++)
            <li class="nav-item">
                <a href="#" class="nav-link" data-lte-toggle="sidebar" role="button">
                    {{ucfirst(Request::segment($i))}}
                </a>
            </li>
        @endfor
    @endif
@endsection
@section('content')
    <section class="content-header px-2">
        <legend>
            {!! $header ?: trans('admin.title') !!}
            <small>{!! $description ?: trans('admin.description') !!}</small>
        </legend>


        <!-- breadcrumb end -->

    </section>

    <section class="content">

        @include('admin::partials.alerts')
        @include('admin::partials.exception')
        @include('admin::partials.toastr')

        @if($_view_)
            @include($_view_['view'], $_view_['data'])
        @else
            {!! $_content_ !!}
        @endif

    </section>
@endsection
