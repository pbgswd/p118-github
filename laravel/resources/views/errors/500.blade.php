@extends('errors::minimal')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __("Server Error. Something isn't right. Maybe let the Maintainer know about it.
    You can send a descriptive message about what you were trying to do to
    <a href='mailto:webster@iatse118.com'>webster@iatse118.com</a>"))
