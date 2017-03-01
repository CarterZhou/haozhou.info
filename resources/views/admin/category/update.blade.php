@extends('admin.layouts.master')

@section('pageTitle')
    <h3>Category page <small>update a category</small></h3>
@endsection

@section('content')
    <div class="x_title">
        <h2>Category - {{ $category->name }}</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form class="form-horizontal form-label-left" method="post" action="{{ route('updateCategory', ['id' => $category->id]) }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="name" class="form-control col-md-7 col-xs-12" name="name" value="{{ old('title')?:$category->name}}">
                    <span class="help-block">{{ $errors->first('name') }}</span>
                </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{ route('categoryList') }}" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/vendors/gentelella/vendors/select2/dist/js/select2.full.min.js') }} "></script>
    <script>
        jQuery(document).ready(function($) {
            $("#tags").select2({});
        });
    </script>
@endsection