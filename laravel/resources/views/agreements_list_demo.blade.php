@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> Agreement Postings'])
@section('content')
<div class="container border border-dark rounded-lg mt-3 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row mb-3 pt-2">
        <div class="col-12 col-md-4"></div>
        <div class="col-12 col-md-4 text-center">
            <h1>
                <i class="far fa-handshake"></i>
                Collective Agreements
            </h1>
        </div>
        <div class="col-12 col-md-4 text-md-right">
            <h3>
               <span class="badge badge-primary badge-pill">
                   {{count($data['agreements'])}}
                   {{Str::plural( 'agreement', count($data['agreements']))}}
               </span>
            </h3>

        </div>
    </div>
    <div class="col-12 p-0 border border-dark rounded-lg mb-3" style="background: rgba(220,220,220,0.8);">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
 <td colspan="3">List of Organizations, Venues, and agreements</td>
                    </tr>
                </thead>
                <tbody>
                @forelse ($data['agreements'] as $agreement)
                    <tr>
                        <td colspan="3">
                            <h5>

                                <a title="{{ $agreement->display_name }}"
                                   href="{{route($agreement->route_name, $agreement->route_parameter)}}">
                                    {{ $agreement->display_name }}

                                </a>
                            </h5>
                            <p><a href="#">Link to list of agreements for {{ $agreement->display_name }}</a></p>
                        </td>

                    @empty
                    <tr>
                        <td colspan="3">
                            <a href="{{route('login')}}">Log in</a>
                            to view available Agreements
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <div class="list-group">
            <ul class="pagination">
              pagination
            </ul>
        </div>
    </div>
</div>
@endsection
