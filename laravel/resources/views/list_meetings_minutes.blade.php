`@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Meetings'])
@section('content')
        <div class="container border border-dark rounded mt-3" style="background: rgba(220,220,220,0.8);">
            <div class="row">
                <div class="col-12 mt-2">
                    @can(['edit articles'])
                        <a class="btn btn-outline-primary float-end"
                           title="Admin Meetings"
                           href="{{route('meetings_list')}}">Admin Meetings</a>
                    @endcan
                </div>
            </div>

            <div class="row d-flex justify-content-around mb-2 mb-md-3">

                <div class="col-12 mt-3 text-center">
                    <h1>Meetings</h1>
                    <h2>Minutes, Documents, Motions, New Business</h2>
            </div>
            @if($data['year'] == '')
                <div class="row d-flex justify-content-around mb-2 mb-md-3">
                    <div class="col-12 text-center">
                        <h3>
                            {{$data['upcoming']->count() == 0 ? 'No' : $data['upcoming']->count()}}
                             General {{Str::plural('Meeting', $data['upcoming']->count())}} Scheduled
                        </h3>
                    </div>
                    <div class="col-12 d-flex">
                        <table class="table-responsive mx-auto border border-dark rounded bg-light p-2">
                        @forelse($data['upcoming'] as $upcoming)
                            <tr>
                                <td class="p-2">
                                    <span class="badge bg-primary text-sm">
                                        {{$upcoming->meeting_type}}
                                        Meeting </span>
                                </td>
                                <td class="px-2 text-left">
                                    <a title="{{ $upcoming->title }}" href="{{route('meeting', $upcoming->id)}}">
                                    {{ $upcoming->title }}
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $upcoming->date->format('F j Y') }},
                                        <i class="far fa-clock"></i>
                                        {{$upcoming->date->format('g:i:s A')}}
                                    </a>

                                    In {{Carbon\Carbon::today()->diffInDays($upcoming->date)}} days.

                                    @if((Carbon\Carbon::today()->diffInDays($upcoming->date)) > 10)
                                        {{(Carbon\Carbon::today()->diffInDays($upcoming->date))-10}}
                                    {{Str::plural('day', Carbon\Carbon::today()->diffInDays($upcoming->date)-10)}}
                                        remaining for submissions.
                                    @else
                                        <span class="badge bg-warning text-dark">Motions closed</span>
                                    @endif
                                    {{$upcoming->motions->count()}} {{Str::plural('motion', $upcoming->motions->count())}}
                                    submitted.
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <div class="col-12 text-center px-2">
                                        No new meetings scheduled right now. Check back for updates.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-2 d-flex align-content-center">
                        <a type="button"
                            href="{{route('topic_show', 'general-meeting-documents')}}"
                            title="General Meeting Documents"
                            class="btn btn-warning mx-auto">
                            View General Meeting Documents
                        </a>
                    </div>
                </div>

                @include('layouts.motion_input_fields')


                    @if($data['newmotions']->count() > 0)
                        <div class="row d-flex mx-auto">
                            <div class="col border border-dark rounded pb-2 mb-3 mb-md-3">
                                <div class="col-12 m-3 text-center">
                                    <h4>Submissions for next General Meeting</h4>
                                </div>
                                <table class="table-responsive mx-auto bg-light p-2 my-2">
                                    @foreach($data['newmotions'] as $newmotion)
                                        <tr>
                                            <td class="p-2">
                                                <span class="badge bg-primary text-sm">{{$newmotion->submission_type}}</span>
                                            </td>
                                            <td class="px-2">
                                                <a href="{{route('member', $newmotion->user->id)}}" title="{{$newmotion->user->name}}">
                                                    <i class="far fa-user"></i> {{$newmotion->user->name}}
                                                </a>
                                                <a title="{{ $newmotion->title }}" href="{{route('motion', $newmotion->id)}}">
                                                    <i class="far fa-file-alt"></i> {{ $newmotion->title }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $newmotion->created_at->format('M j Y, g:i:s A') }}
                                            </td>
                                                <td class="p-2 float-end">
                                                    @if($newmotion->updated_at > $newmotion->created_at)
                                                        Updated: {{$newmotion->updated_at->format('M j Y, g:i:s A')}}
                                                    @endif
                                                </td>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    @endif
               @endif
            <div class="row d-flex justify-content-around mb-2 mb-md-3">
                <form method="post" action="{{route('post_year')}}">
                    @csrf
                    <div class="row justify-content-around border border-dark rounded pb-2 my-3 mb-md-3">
                        <div class="row">
                            <div class="col-12 pt-2">
                                <h5>
                                    @if($data['year'] == '')
                                       View Meetings By Year
                                    @else
                                        {{ $data['count'] }} {{ Str::plural('Meeting', $data['count']) }} for {{$data['year']}}
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-12 mb-2">
                                <select class="custom-select" name="year" id="validationDefault04" required>
                                    @if($data['year'] == '')
                                        <option selected disabled value="">Choose Year</option>
                                    @else
                                        <option selected value="{{$data['year']}}">{{$data['year']}}</option>
                                    @endif
                                    @foreach($data['years'] as $year)
                                        <option value="{{$year->year}}">{{$year->year}}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-outline-primary" type="submit">Submit</button>
                            </div>
                        </div>
                        @if($data['year'] != '')
                            <div class="row">
                                <div class="col-12 text-sm-center text-lg-start">
                                    <h5>
                                        <a href="{{route('list_meetings')}}">List all Meetings</a>
                                    </h5>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            <div class="col-12 mt-3">
                <h4>
                    @if($data['year'] =='')
                        Most recent {{$data['pagination']}}
                        of {{ $data['count'] }} {{ Str::plural('Meeting', $data['count']) }}
                    @endif
                </h4>
            </div>
                <div class="col-12 p-0">
                    <div class="table-responsive border border-dark rounded bg-light">
                    <table class="table">
                        <thead>
                            <tr>
                                <th> @sortablelink('title', 'Title') </th>
                                <th> @sortablelink('meeting_type', 'Type') </th>
                                <th> @sortablelink('date', 'Date') </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $data['meetings'] as $a )
                                <tr>
                                    <td>
                                        <h5>
                                            <a title="{{ $a->title }}" href="{{route('meeting', $a->id)}}">
                                                {{ $a->title }}
                                            </a>
                                            @if($a->date > now())
                                                <span class="badge bg-warning text-dark">Upcoming</span>
                                                In {{ Carbon\Carbon::today()->diffInDays($a->date)  }} days.
                                            @endif
                                        </h5>
                                    </td>
                                    <td> {{ $a->meeting_type }} </td>
                                    <td>
                                        {{$a->date->format('F j Y')}}
                                        @if($a->date > now())
                                            {{$a->date->format('g:i:s A')}}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                    <div class="{{$data['year'] == '' ? 'd-none d-md-block' : ''}}">
                </div>
                <div class="d-flex justify-content-center mt-3">
                    <div class="list-group">
                        <ul class="pagination">
                            {!! $data['meetings']->links() !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
@endsection
