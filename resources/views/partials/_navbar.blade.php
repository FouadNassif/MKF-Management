<nav class="bg-Primary flex justify-between items-center text-white p-1">
    <a class="flex items-center cursor-pointe" href="/">
        <img src="{{ asset('assets/svg/Logo.svg') }}" alt="">
        <h1 class="font-bold text-2xl">MKF Management</h1>
    </a>
    <div>
        @auth
            <div class="flex items-center text-xl gap-2">
                @if (auth()->user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="text-xl">Dashboard</a>
                @endif
                @if (auth()->user()->role == 'cashier')
                    <a href="{{ route('pos.index') }}" class="text-xl">POS</a>
                @endif
                @if (auth()->user()->role == 'waiter')
                    <a href="{{ route('waiter.index') }}" class="text-xl">Waiter</a>
                @endif
                @if (auth()->user()->role == 'driver')
                    <a href="{{ route('driver.index', ['id' => auth()->user()->id]) }}" class="text-xl">Driver</a>
                @endif
                <a href="{{ route('user.profile') }}" class="mx-5"><img src="{{ asset('assets/svg/ProfNav.svg') }}"
                        class="w-12" alt="Profile" title="profile"></a>
                <a href="{{ route('user.logout') }}" onclick="deleteCookiesOnLogout()">
                    <img src="{{ asset('assets/svg/Logout.svg') }}" class="w-12" alt="Logout" title="Logout">
                </a>
            </div>
        @else
            <a href="{{ route('login') }}" class="text-xl">Login </a>
            /
            <a href="{{ route('register') }}" class="text-xl"> Signup</a>
        @endauth
    </div>
</nav>
