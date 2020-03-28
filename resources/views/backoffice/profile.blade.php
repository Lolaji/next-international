@extends('layouts.back')

@section('content')

    <profile-form 
        :user-data="{{ $user }}"
        :csrf-Token="'{{ csrf_token() }}'"></profile-form>
    
@endsection