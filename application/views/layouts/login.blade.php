<!DOCTYPE html>
<html>
  <head>
    <title>3F Developer Suite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{ Asset::container('bootstrapper')->styles() }}
  </head>
  <body>
    
    <div class="row-fluid" >
      <div class="container-fluid">
          <div class="span9">
            @yield('just')
          </div>
          <div class="span3" style="margin-top:100px">
            @yield('login')
          </div>
      </div>
    </div>

    {{ Asset::container('bootstrapper')->scripts() }}
    @yield('scripts')
  </body>
</html>