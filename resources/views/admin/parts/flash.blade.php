<div id="flash-msg" class="alert alert-dismissible {{ $flash_msg['class'] ?? '' }}" style="position:fixed;z-index:10000;right:0;top:10px;min-width:5rem;">
  <script>setTimeout(function(){ $('#flash-msg').hide() }, 5000);</script>
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h5>{{ $flash_msg['title'] ?? '' }} </h5>
  {{ $flash_msg['msg'] ?? '' }}
</div>
