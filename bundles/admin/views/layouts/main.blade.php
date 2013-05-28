<!DOCTYPE html>
<html>
  <head>
    <title>3FDS Admnistrator Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    {{ Asset::container('bootstrapper')->styles() }}
    <style type="text/css"> 
        .loaders {
            display:    none;
            position:   fixed;
            z-index:    1051;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            opacity: 0.8;
            background: #000000 
                        url("{{ url('img/loaders.gif'); }}")
                        50% 50% 
                        no-repeat;
        }

        .loading{
            display: block;
        }
    </style>

  </head>
  <body>
    
    <div class="row-fluid">
      <div class="span12">
        <div class="container-fluid">
          <div class="row">&nbsp;</div>
          <div class="row-fluid">
            <div class="span12">

              <div class="row-fluid">
                <div class="span2">
                  <!--Sidebar content-->
                  {{$sidebar}}
                </div>
                <div class="span10">
                  <!--Body content-->
                  @yield('content')
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  <!-- // <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script> -->
    <!-- {{ HTML::script('js/jquery.js') }}  -->

    {{ Asset::container('bootstrapper')->scripts() }}
    @section('scripts')
    @include('admin::plugin.loggedin')
    <script type="text/javascript">
      $(document).ajaxStart(function() {
        $('<div class="loaders" />').appendTo(document.body);
        $('div.loaders').addClass("loading"); 

      });
      $(document).ajaxComplete(function() {
        $('div.loaders').remove();
        $('div.loaders').removeClass("loading"); 
      });

    </script>
    @yield('scripts')
  </body>
</html>