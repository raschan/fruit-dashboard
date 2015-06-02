@extends('meta.base-user')

@section('pageContent')

<div id="content-wrapper">
  <div class="page-header text-center">
    <h1><i class="fa fa-link page-header-icon"></i>&nbsp;&nbsp;Add an iframe widget</h1>
  </div> <!-- / .page-header -->
  @parent

  <div class="col-md-10 col-md-offset-1">
    <div class="row">
      <div class="col-sm-8 col-md-offset-3 connect-form">
        <div class="panel-body bordered sameHeight">

          @if (!isset($step))

          <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Enter the URL of the webpage</h4>

          {{ Form::open(
          array(
          'url'=>'connect/iframe/2',
          'method' => 'post',
          )
          ) }}

          <div class="col-sm-8">
            <input type="text" name="fullURL" style="width:100%" />
          </div>

          {{ Form::submit('Save', array(
          'class' => 'btn btn-flat btn-info btn-sm pull-right'
          )) }}

          {{ Form::close() }}

          @endif

        </div>
      </div>
    </div>
  </div>
</div> <!-- / #content-wrapper -->

@stop
