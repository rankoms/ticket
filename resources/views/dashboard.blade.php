@extends('layouts.app_mobile')

@section('content')

<main>
    @include('partials.header')
    <div class="content dashboard">
        <div class="wrapper-summary">
            <div class="wrappper-title">
                <span>This Month</span>
            </div>
            <div class="wrappper-isi">
                <div class="isi">
                    <h3>{{$total_barang->jumlah}}</h3>
                    <span>Total barang digudang</span>
                </div>
                <div class="garis-pembatas-vertical"></div>
                <div class="isi">
                    <h3>{{$total_penerimaan->jumlah}}</h3>
                    <span>Penerimaan</span>
                </div>
                <div class="garis-pembatas-vertical"></div>
                <div class="isi">
                    <h3>{{$total_pendistribusian->jumlah}}</h3>
                    <span>Pendistribusian</span>
                </div>
            </div>
        </div>
        <div class="wrapper-penerimaan">
            <div class="wrapper-isi">
                <label>
                    Penerimaan
                </label>
            </div>
            @foreach($penerimaan as $key => $value)
            <div class="wrapper-isi">
                <span>{{$value->name}}</span>
            </div>
            @endforeach
            <div class="wrapper-isi text-right">
                @if(Auth::user()->user_group == 'pic_polda' || Auth::user()->user_group == 'pic_polres')
                <a href="{{route('pic.penerimaan.index')}}">Lihat lebih banyak</a>
                @else
                <a href="{{route('fpb.index')}}">Lihat lebih banyak</a>
                @endif
            </div>
        </div>
        <div class="wrapper-penerimaan">
            <div class="wrapper-isi">
                <label>
                    Pendistribusian
                </label>
            </div>
            @foreach($pendistribusian as $key => $value)
            <div class="wrapper-isi">
                <span>{{$value->name}}</span>
            </div>
            @endforeach
            <div class="wrapper-isi text-right">
                <a href="{{route('pendistribusian.index')}}">Lihat lebih banyak</a>
            </div>
        </div>
    </div>
    @include('partials.footer')
</main>
@endsection

@section('script')

@endsection