@extends('auth.layout.layout')

@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="{{ url('') }}">
        <b>Next</b> International
      </a>
    </div>
    
    <login-form></login-form>

  </div>
@endsection