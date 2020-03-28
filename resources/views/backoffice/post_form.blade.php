@extends('layouts.back')

@section('content')

    <post-form 
        :initial-categories="{{ $categories }}" 
        :post-data="{{ ($is_update && !is_null($post))? $post : 'undefined' }}"
        :csrf-token="'{{ csrf_token() }}'"
        :initial-tags="{{ $tags }}"></post-form>
    
@endsection