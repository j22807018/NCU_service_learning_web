<html>
    <head>
    	<link rel="stylesheet" href="{{ URL::asset('bootstrap/css/bootstrap.min.css') }}" />
      <link rel="stylesheet" href="{{ URL::asset('bootstrap-fileinput/css/fileinput.min.css') }}" />

        @yield('js_css')
        <meta name="csrf-param" content="_token">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>服務學習微課程</title>
    </head>
    <body>
        @include('layouts.top_bar')

        <div class="container-fluid container" id="content" style="margin-top: 60;">        
          <div class="row">
            <div class="margintop rightborder real_content">
              @yield('content')
            </div>
          </div>
        </div>
        <script type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('bootstrap-fileinput/js/fileinput.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('bootstrap-fileinput/js/fileinput_locale_zh-TW.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/upload_file.js') }}"></script>
    </body>

</html>