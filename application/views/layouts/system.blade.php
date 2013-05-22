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
    @yield('scripts')
  </body>
</html>