@extends('layouts.jumbo')
@section('content')
    <!-- https://madewithvuejs.com/vue-carousel
https://jsfiddle.net/quinnssense/bojn4dz4/2/
-->
    <style scoped>
        .VueCarousel-slide {
            position: relative;
            background: #42b983;
            color: #fff;
            font-family: Arial;
            font-size: 24px;
            text-align: center;
            min-height: 100px;
        }

        .label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
<div class="container">
    <div id="app">
        <div id="example"></div>
        @{{ msg }}
    </div>

    <script src="{{asset('/js/app.js')}}"></script>
</div>
@endsection
