@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message')
    Server Error. Something isn't right. <br />
    Please let the Maintainer know about it. <br />
    You can send a descriptive message
    about what you were trying to do<br />
    to: <a href='mailto:webster@iatse118.com'>webster@iatse118.com</a>
@endsection
