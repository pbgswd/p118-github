@extends('layouts.dashboard')
@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Front Page Carousel</h1>
                <h3>4 optimized images </h3>
                <p class="lead">
                    A carousel image requires four images, each for the different screen sizes of devices
                    (phones, laptops, etc). They dont need to be the same image,
                    but there needs to be four of them of the different sizes specified.
                </p>
                <p class="lead">
                    Use your image editor to optimize the image size for delivery over the web. Reduce the file
                    size as much as possible without causing lossiness (degradation).
                </p>
                <p class="lead">
                    When you are ready with your 4 optimized images, create your carousel.
                </p>
                <a class="btn btn-primary" role="button" href="{{route('admin_carousel_create')}}">
                    Create new carousel</a>
            </div>
        </div>
        @foreach($data['image_data'] as $imgData)
        <div class="col-6">
            <img src="/storage/public/{{$imgData['blank']}}" class="pb-2" />
            <h4>
                <i class="far fa-images"></i>
                {{$imgData['size']}}px file, under {{$imgData['filesize']}}kb
            </h4>
        </div>
        @endforeach
    </div>
    <form name="delete" method="POST" action="{{route('admin_carousel_destroy')}}">
        {!! csrf_field() !!}
        {!! method_field('DELETE') !!}
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th> @sortablelink('id','#') </th>
                        <th>  Caption </th>
                        <th>  Button </th>
                        <th> Credit </th>
                        <th> Edit </th>
                        <th> @sortablelink('created_at', 'Created At') </th>
                        <th> @sortablelink('updated_at', 'Updated At') </th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ( $data['carousels'] as $c )
                        <tr>
                            <td>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="id[]" value="{{ $c->id }}" />
                                    </label>
                                </div>
                            </td>
                            <td>{{$c->caption}}</td>
                            <td>
                                <button style="background-color: {{ $c->color ?? '' }}" class=" btn m-2">
                                    {{ $c->color ?? 'none'}}
                                </button>
                            </td>
                            <td>{{$c->credit}}</td>
                            <td>
                                <a href="{{route('admin_carousel_edit', $c->id)}}" title="edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td>{{$c->created_at}}</td>
                            <td>{{$c->updated_at}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                None created yet
                            </td>
                        </tr>
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
                        {{ $data['carousels']->links() }}
                    </ul>
                </div>
            </div>
            <div class="col"></div>
        </div>
    </form>
@endsection
