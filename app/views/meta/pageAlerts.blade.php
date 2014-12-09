@if ($errors)
  @foreach ($errors->all() as $error)
    <script type="text/javascript">
      init.push(function () {
        $.growl.error({
          message: "{{ $error }}",
          size: "large",
          duration: 5000
        });
      });
    </script>
  @endforeach
@endif

@if (Session::get('error'))
  <script type="text/javascript">
    init.push(function () {
      $.growl.error({
        message: "{{ Session::get('error')}}",
        size: "large",
        duration: 5000
      });
    });
  </script>
@endif