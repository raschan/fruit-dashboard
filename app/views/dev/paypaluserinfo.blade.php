@extends('meta.base-user-signout')

@section('pageContent')

<p class="text-center">{{ $accessToken }}</p>
<p class="text-center">{{ $code }}</p>
<p class="text-center">{{ $scope }}</p>
@stop
