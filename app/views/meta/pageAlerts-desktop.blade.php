@if ($errors)
  @foreach ($errors->all() as $error)
    <div class="pa-page-alerts-box hidden-xs">
      <div class="alert pa_page_alerts_default" data-animate="true" style="">
        <button type="button" class="close">×</button><strong>Warning!</strong> {{ $error }}
      </div>
    </div>
  @endforeach
@endif