<html>
    <head>
    	<script type="text/javascript" src="{{ URL::asset('bootstrap/css/bootstrap.min.js') }}"></script>
    	<link rel="stylesheet" href="{{ URL::asset('bootstrap/css/bootstrap.min.css') }}" />

        @yield('js_css')

        <title>NCUSL</title>
    </head>
    <body>
        <!-- @include('layouts.top_bar') -->

        <ul >
		    @if(Auth::check())
			    <li >
			        <li>{{Auth::user()->name}}</li>
			        <li><a href="{{URL::to('logout')}}">登出</a></li>
			    </li>
		    @else
		        <li><a href="{{URL::to('login')}}">登入</a></li>
		    @endif
		</ul>
        <div class="container" id="content" style="margin-top: -37;">        
         
        @yield('content')

        </div>


    </body>

</html>