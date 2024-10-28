@extends('layouts.dashboard',  ['title_icon' => '<i class="fas fa-paint-brush"></i>', 'title' => 'calendar datepicker'])
@section('content')
<script>
    console.log('inside datepicker.blade the template file');
</script>
<div class="row my-5">
    <div class="col-12">
        <a href="{{ route('developer') }}">Resources Page</a> | <a href="{{ route('blank') }}">Development Page</a>
    </div>
    <div class="col-12">

        <div x-data="{ name: 'chidume', age: 28 }">

            <div>Name: <b x-text="name"></b></div>

            <div>Age: <b x-text="age"></b></div>

        </div>
    </div>
    <div class="col-12">
        test datepicker
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <section class="container">
            <h2 class="py-2">Datepicker in Bootstrap 5</h2>
            <form class="row">
                <label for="date" class="col-1 col-form-label">Date</label>
                <div class="col-5">
                    <div class="input-group date" id="datepicker">
                        <input type="text" class="form-control" id="date"/>
                        <span class="input-group-append">
          <span class="input-group-text bg-light d-block">
            <i class="fa fa-calendar"></i>
          </span>
        </span>
                    </div>
                </div>
            </form>
        </section>
<script type="javascript">
    $(function(){
        $('#datepicker').datepicker();
    });
</script>

    </div>

    <div class="col-12">
    </div>
    <div class="col-12">
    </div>
    <div class="col-12">
    </div>
    <div class="col-12">
    </div>
    <div class="col-12">
    </div>
    <div class="col-12">
    </div>

    </div>




@endsection
