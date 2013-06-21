<!DOCTYPE html>
<html>
  <head>
    <title>3F Developer Suite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    {{ Asset::container('bootstrapper')->styles() }}
  </head>
  <body>
    
    
    <div class="row-fluid">
      <div class="span12">
        @include('plugins.fixedTop')
        <div class="container-fluid">
          <div class="row">&nbsp;</div>
          <div class="row-fluid">
            <div class="span12">
              
              <div class="row-fluid">
                <div class="span2">
                  <!--Sidebar content-->
                  {{ $sidebar }}
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
    {{ Asset::container('bootstrapper')->scripts() }}
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    @yield('scripts')
  </body>
</html>