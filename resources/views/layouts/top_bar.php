
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
    