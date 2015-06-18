@extends('meta.base-user')

@section('pageContent')

<div id="content-wrapper">
    @parent
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel-body bordered sameHeight">
                <h4>Your Webhook / API widget is ready.</h4>
                <p>Use this URL to post data to the widget.</p>
                <pre>{{ $url }}</pre>
                <br/>
                <br/>
                <p>Here are some examples about how to do it:</p>
                <ul>
                    <li><a href='http://github.com/tryfruit/api-js-example'>Javascript</li>
                    <li><a href='http://github.com/tryfruit/api-php-example'>PHP</li>
                </ul>
            </div>
        </div>
    </div>
</div> <!-- / #content-wrapper -->

@stop
