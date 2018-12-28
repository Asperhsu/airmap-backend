<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="{{ route('admin.index') }}">
        <i class="fa fa-cog"></i> 管理介面
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link {{ active(['admin.users']) }}" href="{{ route('admin.users') }}">
                    <i class="fa fa-user-cog"></i> 管理帳號
                </a>
            </li>
            <li class="nav-item dropdown {{ active(['admin.probecube', 'admin.independent']) }}">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-wrench"></i> 設備管理
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('admin.probecube') }}">Probecube</a>
                    <a class="dropdown-item" href="{{ route('admin.independent') }}">Independent</a>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="mr-2"><a href="{{ route('home') }}" class="text-light"><i class="fas fa-home"></i> Home</a></li>
            @if (Auth::check())
                <li><a href="{{ route('admin.logout') }}" class="text-light"><i class="fas fa-sign-out-alt"></i> 登出</a></li>
            @endif
        </ul>
    </div>
</nav>