<div id="sessionModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
  <h3 id="myModalLabel">{{ Str::title(Lang::line('global.sessionexpired')->get()) }}</h3>
</div>
<div class="modal-body">
      <div class="alert alert-error">
            <span>Tempoh sesi akan tamat dalam masa  </span><span id="dialogText-warning"></span><span>  saat</span>
      </div>
</div>
<div class="modal-footer">
  <button class="btn" data-dismiss="modal" aria-hidden="true">Continue</button>
  <button id="logoutButton" class="btn btn-primary">Logout</button>
</div>
</div>
<script type='text/javascript'>

      var lifetime = {{ Config::get('session.lifetime'); }} ;// session in minute

      var lifetimeDur = lifetime*60*1000;
      //warning take default not more than 60 second/1 minute
      var warning = 1;
      //set timeout for execute session timeout event
      var timeOut = lifetimeDur - (warning*60*1000);
      //set number of seconds to count down from for countdown ticker
      var countdownTime = warning*60;
      var countdownTickerEvent;
      var path = '{{ URI::segment(2) }}';


      function checkSessionTimeOut(){

            $('#sessionModal').modal('toggle');

            countdownTicker();
            //set as interval event to countdown seconds to session timeout
            countdownTickerEvent = setInterval("countdownTicker()", 1000);


      }

      function countdownTicker()
      {
            if(countdownTime > 0){
                //put countdown time left in dialog box
                $("span#dialogText-warning").addClass('badge badge-important').html(countdownTime);
                 
                //decrement countdownTime
                countdownTime--;
            }

            if(parseInt(countdownTime) < 1){
                 $('#sessionModal').modal('toggle');
                 clearInterval(timeoutTimer);
                 if( path == 'admin'){
                  window.location = "{{ url('admin/login/logout') }}"; 
                 }else{
                  window.location = "{{ url('console/auth/logout') }}";
                 }
                 
            }
      }


      var timeoutTimer = setTimeout(function (){ checkSessionTimeOut()}, timeOut);

      $(document).ready(function() {
          $('body').bind('mousedown keydown', function(event) {

                  countdownTime = warning*60;
                  clearTimeout(timeoutTimer);
                  clearInterval(countdownTickerEvent);
                  timeoutTimer = setTimeout(function (){
                        checkSessionTimeOut()
                  }, timeOut);

          });
      });  

      $('#logoutButton').click(function() {
           if( path == 'admin'){
            window.location = "{{ url('admin/login/logout') }}"; 
           }else{
            window.location = "{{ url('console/auth/logout') }}";
           }
      });



</script>