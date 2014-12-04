@extends('meta.base-user-signout')

@section('pageContent')

<p>Dummy user information:</p><br>
@foreach($user_info as $key => $value)
	<p>{{ $key }} => {{ $value }}</p>
@endforeach

@stop
