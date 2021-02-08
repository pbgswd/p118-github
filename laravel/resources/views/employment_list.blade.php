@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> Employment Postings'])
@section('content')
<div class="container border border-dark rounded-lg mt-3 pt-2 mb-3" style="background: rgba(220,220,220,0.8);">
    <div class="row pt-2 pb-2">
        <div class="col-12 col-md-4"></div>
        <div class="col-12 col-md-4 text-center">
            <h1>
                Employment Postings
            </h1>
        </div>
        <div class="col-12 col-md-4 text-md-right">
            <h3>
                <span class="badge badge-primary badge-pill">
                    {{ $data['count'] }}
                    {{ Str::plural('Posting', $data['count']) }}
                </span>
            </h3>
        </div>
    </div>
    <form method="post" action="{{route('jobs_year')}}">
        @csrf
        <div class="row d-fle justify-content-around border border-dark rounded-lg pb-2 m-2 mb-3 mb-md-3">
            <div class="col-12 pt-2">
                <h5>
                    <label for="validationDefault04">
                        View Jobs By Year
                    </label>
                </h5>
            </div>
            <div class="col-12 col-md-9 mb-2">
                <select class="custom-select" name="deadline" id="validationDefault04" required>
                    <option selected disabled value="">Choose Year</option>
                    @foreach($data['years'] as $year)
                        <option value="{{$year->year}}">{{$year->year}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </form>
    @if($data['year'])
        <div class="row mt-3 mb-3 mb-md-3 p-2">
            <h4>
                Jobs by Year (deadline)
                <span class="font-weight-bold">
                    {{$data['year']}}
                </span>
            </h4>
        </div>
    @endif
    <div class="row p-2">
        <div class="table-responsive border border-dark rounded-lg p-1"
         style="background: rgba(220,220,220,0.8);">
            <table class="table table-sm ml-auto mr-auto">
                <thead>
                    <tr>
                        <th> @sortablelink('title', 'Title') </th>
                        <th>Open/<br />
                            Closed</th>
                        <th> @sortablelink('deadline', 'Deadline') </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $data['employment'] as $e )
                        <tr>
                            <td>
                                <h5>
                                    <a title="{{ $e->title }}" href="{{route('job_view', $e->id)}}">
                                        {{ $e->title }}
                                    </a>
                                </h5>
                            </td>
                            <td>
                                @if($e->jobstatus == 1)
                                    <i class="fas fa-check"></i>
                                @else
                                    <i class="far fa-times-circle"></i>
                                @endif
                            </td>
                            <td>
                                {{ $e->deadline->format('F j Y') }}
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 mt-3">
            <div class="d-flex justify-content-center">
                <div class="list-group">
                    <ul class="pagination">
                        {{$data['employment']->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
