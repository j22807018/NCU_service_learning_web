<div class="navbar navbar-fixed-top navbar-inverse " role="navigation">
  <div class="container">
    <nav class="navbar-header navbar-inverse">
      <a class="navbar-brand" style="color:white; font-size:25px; font-weight:bolder" href="{{URL::route('course.index')}}">服務學習微課程</a>
    </nav>
    <div class="collapse navbar-collapse">
    <ul class="nav navbar-nav navbar-right"style="font-size:15px;">
        @if(auth()->check() && auth()->user()->isAdmin())
          <li><a href="{{URL::route('course.create')}}">新增課程</a></li>
          <li><a href="{{URL::route('questionnaire.index')}}">問卷統計</a></li>
        @endif
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">課程分類<span class="caret"></span></a>
            <ul class="dropdown-menu" >
              <li><a href="{{URL::route('course.index')}}">所有課程</a></li>
              <li><a href="{{URL::route('course.index', ['user' => 'for-student'])}}">學生自主服務</a></li>
              <li><a href="{{URL::route('course.index', ['user' => 'not-for-student'])}}">服務學習課程</a></li>
            </ul>
        </li>
        @if(auth()->check())
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{auth()->user()->name}}<span class="caret"></span></a>
            <ul class="dropdown-menu" >
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