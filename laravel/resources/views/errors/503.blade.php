@extends('errors::minimal')

@section('title', __('Service Unavailable - This site is down'))
@section('code', '503')
@section('message', __('Service Unavailable - contact admin for access.'))
