<!DOCTYPE html>
<html>
  <head>
    <title>3FDS Admnistrator Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    {{ Asset::container('bootstrapper')->styles() }}
  </head>
  <body>
    
    <div class="row-fluid">
      <div class="span12">
        <div class="container-fluid">
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
    @yield('scripts')
  </body>
</html>