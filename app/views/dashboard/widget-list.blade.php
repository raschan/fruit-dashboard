<div class="col-sm-4">
  <div class="stat-panel">
    <div class="stat-cell col-xs-4 bordered no-border-vr no-border-l no-padding valign-middle">
      <ul class="list-group no-margin">
        @foreach ($list as $value)
          <li class="list-group-item no-border-hr padding-xs-hr">
            {{ $value }}
          </li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
