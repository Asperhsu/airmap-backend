<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="https://i.imgur.com/Gro4juQ.png" alt="g0v icon">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="https://v5.airmap.g0v.tw"><i class="fas fa-map"></i> 地圖</a>
            </li>
            <li class="nav-item {{ active('list') }}">
                <a class="nav-link" href="{{ route('list') }}"><i class="fas fa-list-ul"></i> 站點列表</a>
            </li>
            <li class="nav-item {{ active('widget.index') }}">
                <a class="nav-link" href="{{ route('widget.index') }}"><i class="fas fa-tachometer-alt"></i> 小工具</a>
            </li>
            <li class="nav-item {{ active('recruit') }}">
                <a class="nav-link" href="{{ route('recruit') }}"><i class="fas fa-sign-in-alt"></i> 自造站點募集</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="{{ route('admin.index') }}" class="text-light"><i class="fa fa-cog"></i> 管理</a>
            </li>
        </ul>
    </div>
</nav>