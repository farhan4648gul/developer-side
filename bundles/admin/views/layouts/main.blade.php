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
                        url("{{ url('bundles/admin/img/loader.gif'); }}")
                        50% 50% 
                        no-repeat;
        }

        .loading{
            display: block;
        }
    </style>

  </head>
  <body>
    
<div class="container-fluid">
  <div class="row-fluid">
    <div class="span2">
      <!--Sidebar content-->
      {{$sidebar}}
    </div>
    <div class="span10">
      <!--Body content-->
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
       @yield('content')
    </div>
  </div>
</div>

<!-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script> -->
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