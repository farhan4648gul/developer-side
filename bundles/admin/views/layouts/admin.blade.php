<!DOCTYPE html>
<html>
  <head>
    <title>Administrator Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    {{ Asset::container('bootstrapper')->styles() }}
  </head>
  <body>
    
    <div class="row-fluid" style="margin-top:100px">
      <div class="container-fluid">
            @yield('login')
      </div>

    </div>

    {{ Asset::container('bootstrapper')->scripts() }}
    @yield('scripts')
  </body>
</html>