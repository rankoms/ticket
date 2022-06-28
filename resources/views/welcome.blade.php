@extends('layouts.app_mobile')

@section('content')

<main>
    <div class="content-auth">
        <div class="container-carousel">
            <div id="carousel-welcome" class="carousel slide" data-ride="carousel" data-interval="false">
                <ol class="carousel-indicators">
                    @foreach($asset as $key => $value)
                    <li data-target="#carousel-welcome" data-slide-to="{{$key}}" class="{{$key == 0 ? 'active': ''}}"></li>
                    @endforeach
                </ol>
                <div class="carousel-inner">
                    @foreach($asset as $key => $value)
                    <div class="carousel-item {{$key == 0 ? 'active': ''}}">
                        <img src="{{$value['image']}}" class="d-block" alt="{{$value['title']}}" width="198px" height="228px">
                        <div class="wrapper-text">
                            <span>{{$value['title']}}</span>
                            {!! $value['subtitle'] !!}
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-target="#carousel-welcome" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-target="#carousel-welcome" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </button>
            </div>
        </div>
    </div>
    <div class="footer-auth">
        <a href="{{route('scanner.index')}}">Login to Account</a>
    </div>
</main>
@endsection

@section('script')

@endsection