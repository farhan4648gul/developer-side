<script type='text/javascript'>

      var lifetime = {{ Config::get('session.lifetime'); }} ;
      var duration = parseInt(lifetime)*60*1000;
      
      var int=self.setTimeout(function(){loggedin();},duration);

      function loggedin() {
            var loggedin = {{ Auth::check(); }};
            if (!loggedin) {
            	alert('Logout');
            	location.reload();
            }
      }

</script>