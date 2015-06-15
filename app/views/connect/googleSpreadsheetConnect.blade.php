@extends('meta.base-user')

@section('pageContent')

<div id="content-wrapper">
  @parent

      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <div class="panel-body bordered sameHeight">

            @if (!isset($step))

            <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select spreadsheet</h4>

            {{ Form::open(
            array(
            'url'=>'connect/googlespreadsheet/2',
            'method' => 'post',
            )
            ) }}

            <div class="col-sm-8">
              <select name="spreadsheetId" class="form-control">
                @foreach ($spreadsheetFeed as $entry)
                <option value="{{ basename($entry->getId()) }}">{{ $entry->getTitle() }}</option>
                @endforeach
              </select>
            </div>

            {{ Form::submit('Next >', array(
            'class' => 'btn btn-flat btn-info btn-sm pull-right'
            )) }}

            {{ Form::close() }}

            @endif

            @if (isset($step) && ($step == 2))

            <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select worksheet</h4>

            {{ Form::open(
            array(
            'url'=>'connect/googlespreadsheet/3',
            'method' => 'post',
            )
            ) }}

            <div class="col-sm-8">
              <select name="worksheetName" class="form-control">
                @foreach ($worksheetFeed as $entry)
                <option value="{{ $entry->getTitle() }}">{{ $entry->getTitle() }}</option>
                @endforeach
              </select>
            </div>

            {{ Form::submit('Next >', array(
            'class' => 'btn btn-flat btn-info btn-sm pull-right'
            )) }}

            {{ Form::close() }}
            @endif

            @if (isset($step) && ($step == 3))
            <h4><i class="fa fa-link"></i>&nbsp;&nbsp;Select input type</h4>

            {{ Form::open(
            array(
            'url'=>'connect/googlespreadsheet/4',
            'method' => 'post',
            )
            ) }}

            <input type="radio" name="type" value="google-spreadsheet-text-cell"/> Text widget, gets data from cell A2<br/>
            <input type="radio" name="type" value="google-spreadsheet-text-column-random"/> Text widget, randomly displays a cell from column A<br/>
            <input type="radio" name="type" value="google-spreadsheet-text-column"/> List widget, gets data from column A<br/>
            <input type="radio" name="type" value="google-spreadsheet-line-cell"/> Graph widget, gets data from cell A2<br/>
            <input type="radio" name="type" value="google-spreadsheet-line-column"/> Graph widget, gets dates from column A, values from column B<br/>

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
