@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">FAQ Topics list</h1>
            <p class="lead">
                FAQs have a top level topic term, with a list of questions and answers attached.
            </p>
            <a class="btn btn-primary" href="{{route('admin_faq_create')}}" role="button">
                Create FAQ
            </a>
        </div>
    </div>
    <div class="row p-5">
        <div class='col-12'>
            <h3>List of FAQs</h3>
        </div>
        <div class='col-12'>
            <form name="delete" method="POST" action="{{route('admin_faq_destroy')}}">
                {!! csrf_field() !!}
                {!! method_field('DELETE') !!}
                <div class="form-group">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th> @sortablelink('id','#') </th>
                                    <th> @sortablelink('faq_topic', 'Topic') </th>
                                    <th> @sortablelink('access_level', 'Access Level') </th>
                                    <th> @sortablelink('live', 'Is Live?') </th>
                                    <th> Edit </th>
                                    <th> @sortablelink('created_at', 'Created At') </th>
                                    <th> @sortablelink('updated_at', 'Updated At') </th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($data['faqs'] as $faq)
                                <tr>
                                    <td>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="id[]" value="{{$faq->id}}" />
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <h4>
                                            <a title="{{ $faq->faq_topic }}"
                                               href="{{ route('admin_faq_edit', $faq->slug) }}">
                                               {{ $faq->faq_topic }}
                                            </a>
                                        </h4>
                                    </td>
                                    <td> {{ $faq->access_level }} </td>
                                    <td> {!! $faq->live ? "<i class='fas fa-check'></i>"
                                            : "<i class='far fa-times-circle'></i>" !!}
                                    </td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('admin_faq_edit', $faq->slug)}}"
                                           role="button">
                                            Edit FAQ</a>
                                    </td>
                                    <td> {{ $faq->created_at->format('F j Y H:i:s') }} </td>
                                    <td> {{ $faq->updated_at->format('F j Y H:i:s') }} </td>
                                </tr>
                            @empty
                                no data
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
                <div class="row mb-lg-5">
                    <div class="col">
                        <i class="far fa-trash-alt fa-2x"></i>
                        <input class="btn btn-outline-danger" type="submit" value="Delete Selected">
                    </div>
                    <div class="col-6">
                        <div class="list-group">
                            <ul class="pagination">
                                {{ $data['faqs']->links() }}
                            </ul>
                        </div>
                    </div>
                    <div class="col"></div>
                </div>
            </form>
        </div>
    </div>
@endsection
