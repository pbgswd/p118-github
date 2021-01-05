@extends('layouts.jumbo')
@section('content')
<div class="container">
    <div class="row border border-light rounded-lg p-lg-2 mb-2" style="background: #fff;">
        <div class="col-12 mb-lg-1">
            <h1>{{config('app.name')}}</h1>
        </div>
    </div>
    <div class="row border border-light rounded-lg p-lg-2" style="background: rgba(220,220,220,0.8);">
        <div class="col-12">
            <h1> Executive </h1>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" colspan="3"></th>
                    <th scope="col">From</th>
                    <th scope="col">Until</th>
                </tr>
            </thead>
            <tbody>
            @forelse($data as $e)
                <tr>
                    <td colspan="5">
                        <h3>{{$e->title}}</h3>
                    </td>
                </tr>
                @forelse($e->current_executive_user as $exec)
                <tr>
                    <td> &nbsp;</td>
                    <td>
                        <h4>
                            @auth
                                <a title="{{ $exec->name }}" href="{{ route('member', $exec->id) }}">
                                    @endauth
                                    {{$exec->name ?? ''}}
                                    @auth
                                </a>
                            @endauth
                        </h4>
                    <td>
                        <a href="mailto:{{$e->email}}">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($exec->pivot->start_date)->format('M j Y')}}
                    </td>
                    <td>
                        {{\Carbon\Carbon::parse($exec->pivot->end_date)->format('M j Y')}}
                    </td>
                </tr>
                @empty
                    <tr>
                        <td colspan="5">No entry</td>
                    </tr>
                @endforelse
            @empty
                <tr>
                    <td colspan="5">No entry</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection
