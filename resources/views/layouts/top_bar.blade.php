<div class="navbar navbar-fixed-top navbar-inverse " role="navigation">
  <div class="container">
    <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right">
      @if(auth()->check())
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{auth()->user()->name}}<span class="caret"></span></a>
          <ul class="dropdown-menu" >
            <li><a href="{{URL::route('course.index')}}">課程列表</a></li>
            @if(auth()->user()->isAdmin())
                <li><a href="{{URL::route('course.create')}}">新增課程</a></li>
            @endif
            <li><a href="{{URL::to('logout')}}">登出</a></li>
          </ul>
      </li>
      @else
      <li>
        <a href="{{URL::to('login')}}">登入</a>
      </li>
      @endif
    </ul>
    </div>
  </div>
</div>