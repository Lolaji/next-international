@extends('layouts.back')

@section('content')

    <service-manager :initial-services="{{ $services }}"></service-manager>
    
@endsection