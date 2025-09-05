<footer class="footer">
    <div class="container-fluid">
        <nav class="pull-left">
            {{-- <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link" href="http://www.themekita.com">
                        ThemeKita
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Help
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Licenses
                    </a>
                </li>
            </ul> --}}
        </nav>
        <div class="copyright text-center ms-auto">
            2024, All Rights Reserved by <a href="{{route('admin.dashboard')}}">{{ $generalSettings->app_name ?? 'Larabel' }}</a>
        </div>
    </div>
</footer>