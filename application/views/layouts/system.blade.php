<!DOCTYPE html>
<html>
  <head>
    <title>3F Developer Suite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    {{ Asset::container('bootstrapper')->styles() }}
  </head>
  <body>
    
    
    <div class="row-fluid">
      <div class="span12">
        @include('plugins.fixedTop')
        <div class="container-fluid">
          <!-- <div class="row">&nbsp;</div> -->
          <div class="row-fluid">
            <div class="span12">
              
              <div class="row-fluid">
                <div class="span2">
                  <!--Sidebar content-->
                  <div class="row">&nbsp;</div>
                  <aside>{{ $sidebar }}</aside>
                  <div class="pull-left">
                    <div id="date"></div>
                  </div>
                  
                </div>
                <div class="span10">
                  <!-- <div class="row-fluid">{{Breadcrumb::create(array('Home' => '#', 'Library' => '#', 'Data'));}}</div> -->
                  <!--Body content-->
                  @yield('content')
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    {{ Asset::container('bootstrapper')->scripts() }}
    @include('admin::plugin.loggedin')
    <script>

    startTime();

    function startTime()
    {
      var today=new Date();
      var h=today.getHours();
      var m=today.getMinutes();
      var s=today.getSeconds();
      var day=today.toDateString();
      // add a zero in front of numbers<10
      m=checkTime(m);
      s=checkTime(s);
      $('#date').empty().html(day);
      $('#date').append(' '+h+":"+m+":"+s);
      t=setTimeout(function(){startTime()},500);
    }

    function checkTime(i)
    {
      if (i<10){
        i="0" + i;
      }
      return i;
    }

      function profileInfo(url){

        $('#profileModal').modal('toggle');

        $.get(url, function(data,status){

          for (x in data)
          {   
            $('#updateProfileForm input[name="'+ x +'"]' ).val(data[x]);
          }

          },"json");

      }


      $('#editProfileBtn').click(function() {
        
        $.post('{{url("console/user/profile")}}', $("#updateProfileForm").serialize(),function(data) {
                sourcedata = data;
              }).success(function() { 
              
              for (x in sourcedata)
              {   
                $('#updateProfileForm input[name="'+ x +'"]' ).val(sourcedata[x]);
              }

              var notfail = '<div class="alert alert-success" >' +
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<strong>Update Success!!!</strong> Profile information successfully updated.</div>'


              $('.modal-body').prepend(notfail);

              }).fail(function() { 

              var notfail = '<div class="alert alert-error" >' +
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<strong>Update Fail!!!</strong> Profile information update failed.</div>'


              $('.modal-body').prepend(notfail);

              });

      });



      $('#resetBtn').click(function() {
        
        $.post('{{url("console/user/resetpassword")}}', $("#resetForm").serialize(),function(data) {
                sourcedata = data;
              }).success(function() { 

              var notfail = '<div class="alert alert-success" >' +
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<strong>Update Success!!!</strong> Password successfully updated.</div>'


              $('#resetModalBody').prepend(notfail);
              $('#resetForm :input').val('');

              }).fail(function() { 

              var notfail = '<div class="alert alert-error" >' +
                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                    '<strong>Update Fail!!!</strong> Password update failed.</div>'


              $('#resetModalBody').prepend(notfail); 

              });


      });


    </script>
    <script type="text/javascript">
      $(document).ajaxStart(function() {
        $('body').modalmanager('loading');
      });
      $(document).ajaxComplete(function() {
        $('body').modalmanager('loading');
      });

    </script>
    @yield('scripts')
  </body>
</html>