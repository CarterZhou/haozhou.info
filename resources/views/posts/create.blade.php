<h1>Create a post</h1>
<form action="{{ route('createPost') }}" method="post">
    {{ csrf_field() }}
    <input type="text" name="title" value="{{ old('title') }}">
    <span>{{ $errors->first('title') }}</span>
    <textarea name="body" id="" cols="30" rows="10">{{ old('body') }}</textarea>
    <span> {{ $errors->first('body') }}</span>
    <button>Create</button>
</form>