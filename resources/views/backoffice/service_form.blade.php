@extends('layouts.back')

@section('content')

    <service-form :service-data="{{ ($is_update)?$service : 'undefined' }}" :csrf-token="'{{ csrf_token() }}'"></service-form>
    
@endsection