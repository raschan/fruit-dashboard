



<!-- Modal box -->
<div id="modal-sizes-1" class="modal fade" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h4 class="modal-title">Warning</h4>
      </div>
      <div class="modal-body">
        Are you sure you want to disconnect stripe from your account? <br>
        After disconnecting we will not receive any more data from stripe.</div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <a onClick= '_gaq.push(["_trackEvent", "Disconnect", "Stripe disconnected"]);mixpanel.track("Disconnect",{"service":"stripe"});' href="{{ URL::route('auth.disconnect', 'stripe') }}"><button type="button" class="btn btn-danger">Disconnect</button></a>
    </div>
    </div> <!-- / .modal-content -->
  </div> <!-- / .modal-dialog -->
</div>
<!-- /Modal box -->
<button class="btn-link sm-pull-right" data-toggle="modal" data-target="#modal-sizes-1">Disconnect</button>