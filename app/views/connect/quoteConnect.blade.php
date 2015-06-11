@extends('meta.base-user')

@section('pageContent')

<div id="content-wrapper">
  @parent

  <div class="col-md-10 col-md-offset-1">
    <div class="row">
      <div class="col-sm-8 col-md-offset-3 connect-form">
        <div class="panel-body bordered sameHeight">

          @if (!isset($step))

          {{ Form::open(
          array(
          'url'=>'connect/quote/2',
          'method' => 'post',
          )
          ) }}

          <h4>Choose quote type</h4>

          <input type="radio" name="type" value="quote-inspirational" checked="checked"/> Inspirational quotes<br/>
          <input type="radio" name="type" value="quote-funny"/> Funny quotes<br/>
          <input type="radio" name="type" value="quote-first-line"/> First lines of famous books<br/>

          <br/>
          <br/>

          <h4>Choose quote refresh frequency</h4>

          <input type="radio" name="refresh" value="daily" checked="checked"/> Daily<br/>
          <input type="radio" name="refresh" value="every-reload"/> Every reload<br/>

          <h4>Choose quote language</h4>

          <input type="radio" name="language" value="english" checked="checked"/> English<br/>
          <input type="radio" name="language" value="hungarian"/> Hungarian<br/>

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
