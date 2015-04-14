@extends('meta.meta')

@section('body')

@section('navbar')
@include('meta.navbar')
@show

@section ('pageAlert')
@include('meta.pageAlerts')
@show

@section('pageContent')
@show

<div class="row no-margin">
  <div class="col-md-2 col-md-offset-5">
    <a href="https://www.positivessl.com">
      <img class='img-responsive center-block' src="https://www.positivessl.com/images-new/PositiveSSL_tl_trans2.png" alt="SSL Certificate" title="SSL Certificate"/>
    </a>
  </div>
</div>

@section('footer')
@include('meta.footer')
@show

</body>

@stop