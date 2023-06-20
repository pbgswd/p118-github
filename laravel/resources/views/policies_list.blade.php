@extends('layouts.jumbo',  ['title' => '<i class="fas fa-scroll"></i> Policies'])
@section('content')


<div class="container border border-dark rounded-lg mt-3 mb-3 p-2" style="background: rgba(220,220,220,0.8);">
    <div class="jumbotron-fluid text-center">
        <h1>
            <i class="fas fa-scroll"></i>
            Local 118 Policies
        </h1>
        <h3>
               <span class="badge badge-primary badge-pill">
                   {{ $data['data']['count'] }} Policy Documents
               </span>
        </h3>
        <div class="row mt-3">
            <div class="col-12 pt-2">
                <h4 class="font-italic">Please remember, we have pledged to keep confidential the work of this body and
                    to do all in our power to discourage and prevent violation of this requirement by brother and
                    sister members.
                </h4>
            </div>
        </div>
    </div>
    <div class="col-12 border border-dark rounded-lg p-1" style="background: rgba(220,220,220,0.8);">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th> @sortablelink('title', 'Title') </th>
                    <th> @sortablelink('date', 'Date') </th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $data['data']['policies'] as $policy )
                    <tr>
                        <td>
                            <h5>
                                <a title="{{ $policy->title }}" href="{{route('policy_show_public', $policy->id)}}"> {{ $policy->title }}</a>
                            </h5>
                        </td>
                        <td>
                            {{ $policy->date->format('F j Y') }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <div class="list-group">
                <ul class="pagination">
                    {{$data['data']['policies']->links()}}
                </ul>
            </div>
        </div>
    </div>
@endsection
