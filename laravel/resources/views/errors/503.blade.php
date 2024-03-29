@extends('errors::minimal')

@section('title', __('Service Unavailable - This site is down temporarily if you see this message.'))
@section('code', '503')
@section('message', __('The website service has been paused temporarily. Check back in a few minutes.'))
