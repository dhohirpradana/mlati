@extends('layouts.layout')
@section('title', 'Website Resmi Kelurahan ' . App\Kelurahan::find(1)->nama_kelurahan . ' - Statistik Penduduk')

@section('styles')
    <meta name="description"
        content="Statistik Penduduk Kelurahan {{ App\Kelurahan::find(1)->nama_kelurahan }}, Kecamatan {{ App\Kelurahan::find(1)->nama_kecamatan }}, Kabupaten {{ App\Kelurahan::find(1)->nama_kabupaten }}.">
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/stock/modules/accessibility.js"></script>
@endsection

@section('header')
    <h1 class="text-white text-muted">STATISTIK PENDUDUK</h1>
    <p class="text-white">Statistik Penduduk Kelurahan {{ $kelurahan->nama_kelurahan }}, masyarakat dapat dengan mudah
        mengetahui
        informasi mengenai statistik penduduk kelurahan {{ $kelurahan->nama_kelurahan }}.</p>
@endsection

@section('content')
    <div class="row">
        @include('statistik-penduduk.card')
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/statistik-penduduk.js') }}"></script>
@endpush
