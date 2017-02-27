@extends('admin.layouts.master')

@section('pageTitle')
    <h3>Category page <small>managing blog categories</small></h3>
@endsection

@section('content')
    <div class="x_title">
        <div class="pull-right">
            <a href="{{ route('categoryCreateView') }}" class="btn btn-primary btn-sm">New</a>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
        <div class="table-responsive">
            <table class="table table-striped jambo_table bulk_action">
                <thead>
                <tr class="headings">
                    <th class="column-title" style="display: table-cell;">Name </th>
                    <th class="column-title" style="display: table-cell;">Date of creation </th>
                    <th class="column-title no-link last" style="display: table-cell;"><span class="nobr">Action</span></th>
                </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr class="category-item">
                        <td><a href="">{{ $category->name }}</a></td>
                        <td>{{ $category->created_at }}</td>
                        <td class="last">
                            <form action="{{ route('deleteCategory', ['id' => $category->id]) }}" method="post" class="delete-form">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <input type="hidden" value="{{ $category->id }}" name="id">
                                <button name="delete-post-#{{ $category->id }}" class="btn btn-danger btn-xs">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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