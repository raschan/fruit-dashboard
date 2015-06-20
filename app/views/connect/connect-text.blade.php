@extends('meta.base-user')

@section('pageContent')

<div id="content-wrapper">
  @parent

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel-body bordered sameHeight">

            @if (isset($step) && ($step == 'select-source'))
                <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select text source</h4>

                {{ Form::open(
                array(
                'url'=>'connect/text/1',
                'method' => 'post',
                )
                ) }}

                <input type="radio" name="source" value="text"/> Enter the text manually<br/>
                <input type="radio" name="source" value="google-spreadsheet-text-cell"/> Google Spreadsheet, gets data from cell A2<br/>
                <input type="radio" name="source" value="google-spreadsheet-text-column-random"/> Google Spreadsheet, randomly displays a cell from column A<br/>

                {{ Form::submit('Save', array(
                'class' => 'btn btn-flat btn-info btn-sm pull-right'
                )) }}

                {{ Form::close() }}
            @endif

            @if (isset($step) && ($step == 'init'))
                <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select text source</h4>

                {{ Form::open(
                array(
                'url'=>'connect/text/type',
                'method' => 'post',
                )
                ) }}

                <input type="radio" name="type" value="text"/> Enter the text manually<br/>
                <input type="radio" name="type" value="google-spreadsheet-text-cell"/> Google Spreadsheet, gets data from cell A2<br/>
                <input type="radio" name="type" value="google-spreadsheet-text-column-random"/> Google Spreadsheet, randomly displays a cell from column A<br/>

                {{ Form::submit('Save', array(
                'class' => 'btn btn-flat btn-info btn-sm pull-right'
                )) }}

                {{ Form::close() }}
            @endif

            @if (isset($step) && ($step == 'enter-text'))
                <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Enter text</h4>

                {{ Form::open(
                array(
                'url'=>'connect/text/save-text',
                'method' => 'post',
                )
                ) }}

                <div class="col-sm-8">
                  <input type="text" name="text" style="width:100%" />
                </div>

                {{ Form::submit('Save', array(
                'class' => 'btn btn-flat btn-info btn-sm pull-right'
                )) }}

                {{ Form::close() }}

            @endif

            </div>
        </div>
    </div>
</div> <!-- / #content-wrapper -->

@stop
