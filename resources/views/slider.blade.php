@extends('layouts.user')

@section('title', $slider->tieuDe)

@section('css')

<link href="{{ asset('css/listing.css') }}" rel="stylesheet">

@endsection
@section('content')
<main>
    <div class="top_banner">
        <div class="opacity-mask d-flex align-items-center" data-opacity-mask="rgba(0, 0, 0, 0.3)">
            <div class="container">
                <div class="breadcrumbs">
                    <ul>
                        <li><a href="{{ route('home') }}">Trang chủ</a></li>
                        <li>{{ $slider->tieuDe }}</li>
                    </ul>
                </div>
                <h1>{{ $slider->tieuDe }}</h1>
            </div>
        </div>
        <img src="{{ asset('img/banner.png') }}" class="img-fluid" alt="Banner">
    </div>
    <div class="container">
        {!! $slider->noiDung !!}
    </div>
</main>
@endsection