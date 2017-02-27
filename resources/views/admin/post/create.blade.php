@extends('admin.layouts.master')

@section('styles')
    <link href="{{ asset('/vendors/gentelella/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('pageTitle')
    <h3>Post page <small>create a post</small></h3>
@endsection

@section('content')
    <div class="x_title">
        <h2>New post</h2>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <form class="form-horizontal form-label-left" method="post" action="{{ route('createPost') }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">Title <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="title" class="form-control col-md-7 col-xs-12" name="title" value="{{ old('title') }}">
                    <span class="help-block">{{ $errors->first('title') }}</span>
                </div>
            </div>

            <div class="form-group {{ $errors->has('body') ? 'has-error' : ''}}">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Body <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea class="form-control" rows="10" name="body">{{ old('body') }}</textarea>
                    <span class="help-block">{{ $errors->first('body') }}</span>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Category <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" name="category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Tags </label>
                <div class="col-md-6 col-sm-6 col-xs-12" >
                    <select name="tags[]" id="tags" class="form-control" multiple>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="ln_solid"></div>
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a href="{{ route('postList') }}" class="btn btn-default">Back</a>
                    <button type="submit" class="btn btn-success">Create</button>
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