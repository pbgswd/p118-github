@extends('layouts.jumbo',  ['title' => '<i class="fas fa-list"></i> List Members'])

@section('content')
    <div class="container border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); max-width:768px;">
    <h1 class="display-3"></h1>
        <h3>
           <span class="badge badge-primary badge-pill">
               {!! $data['users']->total()  !!}
           </span>
            Members. | <a href="{{route('member', Auth::user()->id)}}">View my profile <i class="far fa-arrow-alt-circle-right"></i> </a>
        </h3>
</div>

    <div class="table-responsive-md border border-dark rounded-lg" style="background: rgba(220,220,220,0.6); padding:1em;  max-width:768px; margin-left:auto; margin-right:auto;">
        <table class="table table-dark table-sm" style="margin-left:auto; margin-right:auto;">
            <thead>
                <tr>
                      <th> @sortablelink('name', 'Name') </th>
                    <th> @sortablelink('email', 'Email') </th>
                </tr>
            </thead>
            <tbody>
            @foreach ( $data['users'] as $i )
                <?php
                //dd($i->user_info->show_profile);
                ?>
                <tr>
                    <td>
                        <h4>
                            @if (!empty($i->user_info->show_profile))
                                <a title="{{ $i->name }}" href="{{ route('member', $i->id) }}">
                            @endif
                            {{ $i->name }}
                            @if (!empty($i->user_info->show_profile))
                                </a>
                            @endif
                        </h4>
                    </td>
                    <td>
                        @if (!empty($i->user_info->share_email))
                        <a href="mailto:{{ $i->email }}">{{ $i->email }}</a>
                        @endif
                    </td>
                </tr>
            @endforeach
                <tr>
                    <td colspan="6">&nbsp;</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row" style="margin-top:2em;">
        <div class="col-5"></div>
        <div class="col-3">
            <div class="list-group">
                <ul class="pagination">
                    {!! $data['users']->links() !!}
                </ul>
            </div>
        </div>
        <div class="col-3"></div>
    </div>

    <div class="row" style="margin-top:6em;"></div>
@endsection
