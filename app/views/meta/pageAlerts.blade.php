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

@if (Session::get('success'))
  <script type="text/javascript">
    init.push(function () {
      $.growl.notice({
        title: "Success!",
        message: "{{ Session::get('success')}}",
        size: "large",
        duration: 5000
      });
    });
  </script>
@endif