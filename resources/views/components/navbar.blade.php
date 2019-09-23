<nav class="navbar is-black is-fixed-top">
    <div class="container is-uppercase">
        <div class="navbar-brand">
            <a class="navbar-item">
                <div>
                    <small style="font-size: 9px;">MOONBOWMC</small><br/>
                    <div style="margin-top: -12px;">Control Panel</div>
                </div>
            </a>

            <a role="button" class="navbar-burger">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu">
            @guest

            <div class="navbar-start">
                <a class="navbar-item" href="/forum">
                    <i class="fab fa-discord" style="margin-right: 8px;"></i> FORUM
                </a>
            </div>

            <li class="navbar-end">
                <a class="navbar-item" href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i> {{ __('Login') }}
                </a>
                <a class="navbar-item" href="{{ route('register') }}">
                    <i class="fas fa-user-plus" style="margin-right: 8px;"></i> {{ __('Register') }}
                </a>
            </li>
            @else
                <div class="navbar-start">

                    <a class="navbar-item" href="/home">
                        <i class="fas fa-home" style="margin-right: 8px;"></i> HOME
                    </a>

                    <a class="navbar-item" href="/store">
                        <i class="fas fa-shopping-bag" style="margin-right: 8px;"></i> STORE
                    </a>

                    <a class="navbar-item" href="/statistics">
                        <i class="fas fa-diagnoses" style="margin-right: 8px;"></i> STATISTICS
                    </a>

                    <a class="navbar-item" href="/topup">
                        <i class="fas fa-donate" style="margin-right: 8px;"></i> TOPUP
                    </a>

                    <a class="navbar-item" href="/forum">
                        <i class="fab fa-discord" style="margin-right: 8px;"></i> FORUM
                    </a>
                </div>
                <div class="navbar-end">
                        @if(Auth::user()->role->role_id == 1)

                        <a class="navbar-item" href="{{ route('admin.controlpanel') }}">
                            <i class="fas fa-cogs" style="margin-right: 8px;"></i> แผงควบคุม
                        </a>

                        @endif
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link"><i class="fas fa-user" style="margin-right: 8px;"></i>{{ Auth::user()->name }}</a>
                        <div class="navbar-dropdown is-boxed">

                            <a class="navbar-item has-text-pink">
                                คุณอยู่ในสถานะ {{ Auth::user()->role->role_name }}
                            </a>

                            <hr class="navbar-divider">

                            <a href="{{ route('profile.index') }}" class="navbar-item">
                                โปรไฟล์
                            </a>

                            <a class="navbar-item" href="{{ route('logout') }}">
                                ออกจากระบบ
                            </a>
                        </div>
                    </div>
            @endguest
        </div>
    </div>

</nav>
