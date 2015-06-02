<li class="dashboard-widget well" data-row="1" data-col="1" data-sizex="2" data-sizey="2"> 
  <ul>
    @foreach ($list as $value)
      <li class="list-group-item no-border-hr padding-xs-hr">
        {{ $value }}
      </li>
    @endforeach
  </ul>
</li>
