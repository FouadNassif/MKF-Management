@extends('components.layout')

@section('title', 'MKF - Driver')

@section('content')
    @include('partials._navbar')
    {{ $orders[0]['items'][0]['item']['name'] }}
@endsection

@section('scripts')
    <script></script>
@endsection
