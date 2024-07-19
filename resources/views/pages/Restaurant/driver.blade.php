@extends('components.layout')

@section('title', 'MKF - Driver')

@section('content')
    @include('partials._navbar')
    <div class="w-[400px] mx-auto py-[100px] flex flex-col gap-4">
        @component('components.cardDropDown', ['extended' => '1'])
            @slot('compressed')
                Compressed
            @endslot
            Extended
        @endcomponent

        @component('components.cardDropDown')
            @slot('compressed')
                Compressed
            @endslot
            Extended
        @endcomponent
    </div>
    <div>
        Available Orders
    </div>
    {{-- {{ $orders[0]['items'][0]['item']['name'] }} --}}
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/cardDropDown.js') }}"></script>
@endsection
