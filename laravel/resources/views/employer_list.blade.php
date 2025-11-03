@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> Employment Postings'])
@section('content')
    <div class="container border border-dark rounded mt-3 pt-2 mb-3" style="background: rgba(220,220,220,0.8);">
        <div class="row pt-2 pb-2">
            <div class="col-12 col-md-4"></div>
            <div class="col-12 col-md-4 text-center">
                <h1>{{$data['contactlist']['title']}}</h1>
            </div>


        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>

                </thead>
                <tbody>
                    @forelse ( $data['contactlistdata'] as $cld )
                        <tr>
                            <td class="pt-6">
                                <div class="row mx-6"></div>
                                <a id="contact{{$cld['id']}}" class="mt-6"></a>
                                <div class="row p-3 mt-6">
                                <h4> {{$cld['name']}}</h4>
                                {{$cld['addr1']}}
                                {{$cld['addr2']}} <br />
                                {{$cld['city']}} {{$cld['province']}} {{$cld['country']}} {{$cld['postal_code']}} <br />
                                <a href="{{$cld['website']}}" title="{{$cld['name']}}" target="_blank">{{$cld['website']}}</a> <br />
                                <a href="mailto:{{$cld['email']}}">{{$cld['email']}}</a> <br />
                                Contact: {{$cld['contact']}} <br />
                                Phone: <a href="tel:{{$cld['phone']}}">{$cld['phone']}}</a> <br />
                                Info: <br />
                                {!! $cld['notes'] !!} <br /><br />
                                <br />
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">Nothing posted</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
