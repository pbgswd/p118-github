@extends('layouts.dashboard')
@section('content')
<script>
    $("#pdate").datepicker({showOn: 'focus',changeMonth: true,
    changeYear: true,dateFormat: 'yy-mm-dd',
    minDate: new Date(currentYear, currentMonth, currentDate)
    });
</script>


    <div class='container' style='margin-top: 100px;'>
        container 1
        <input type='text' name="date" class="form-control" id="pdate" data-provide="datepicker" style='width: 300px;' >

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                <button class="dropdown-item" type="button">Action</button>
                <button class="dropdown-item" type="button">Another action</button>
                <button class="dropdown-item" type="button">Something else here</button>
            </div>
        </div>

    </div>



<div class="container">
container 2
    <div class="container">
        <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' class="form-control" />
                        <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker1').datetimepicker();
                });
            </script>
        </div>
    </div>
    </div>
    <div class="row" style="margin-top:30px;"> &nbsp;</div>
@endsection
