@extends('layouts.back')

@section('content')

    <post-manager :initial-posts="{{ Auth::user()->posts()->latest()->get() }}"></post-manager>
    
@endsection