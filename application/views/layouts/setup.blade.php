<!DOCTYPE html>
<html>
  <head>
    <title>3F Suite Administrator Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    {{ Asset::container('bootstrapper')->styles() }}
  </head>
  <body>
    
    <div class="row-fluid" style="margin-top:100px">
      <div class="container-fluid">
        @if (isset($errors) && count($errors->all()) > 0)
        <div class="alert alert-error">
            <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading">Oh Snap!</h4>
            <ul>
            @foreach ($errors->all('<li>:message</li>') as $message)
            {{ $message }}
            @endforeach
            </ul>
        </div>
        @elseif (!is_null(Session::get('status_error')))
        <div class="alert alert-error">
            <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading">Oh Snap!</h4>
            @if (is_array(Session::get('status_error')))
                <ul>
                @foreach (Session::get('status_error') as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            @else
                {{ Session::get('status_error') }}
            @endif
        </div>
        @endif
         
        @if (!is_null(Session::get('status_success')))
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert" href="#">×</a>
            <h4 class="alert-heading">Success!</h4>
            @if (is_array(Session::get('status_success')))
                <ul>
                @foreach (Session::get('status_success') as $success)
                    <li>{{ $success }}</li>
                @endforeach
                </ul>
            @else
                {{ Session::get('status_success') }}
            @endif
        </div>
        @endif
            @yield('setup')
      </div>

    </div>

    {{ Asset::container('bootstrapper')->scripts() }}
    @yield('scripts')
  </body>
</html>