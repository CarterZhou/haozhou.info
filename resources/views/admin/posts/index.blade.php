@extends('admin.layouts.master')

@section('pageTitle')
    <h3>Post page <small>managing blog posts</small></h3>
@endsection

@section('content')
<div class="table-responsive">
    <table class="table table-striped jambo_table bulk_action">
        <thead>
        <tr class="headings">
            <th class="column-title" style="display: table-cell;">Title </th>
            <th class="column-title" style="display: table-cell;">Views </th>
            <th class="column-title" style="display: table-cell;">Date of creation </th>
            <th class="column-title no-link last" style="display: table-cell;"><span class="nobr">Action</span></th>
        </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr class="post-item">
                <td><a href="{{ route('postSingle', ['slug' => $post->slug]) }}">{{ $post->title }}</a></td>
                <td>{{ $post->views }}</td>
                <td>{{ $post->created_at }}</td>
                <td class=" last">
                    <form action="{{ route('deletePost', ['id' => $post->id]) }}" method="post" class="delete-form">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" value="{{ $post->id }}" name="id">
                        <button name="delete-post-#{{ $post->id }}" class="btn btn-danger btn-xs">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function($) {
            $('.delete-form').on('submit', function (e) {
                if (!confirm('Are you sure to delete?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection