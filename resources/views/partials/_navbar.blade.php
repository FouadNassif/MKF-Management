<nav class="bg-Primary flex justify-between items-center text-white p-1">
    <a class="flex items-center cursor-pointe" href="/">
        <img src="{{ asset('assets/svg/Logo.svg') }}" alt="">
        <h1 class="font-bold text-2xl">MKF Management</h1>
    </a>
    <div>
        @auth
            <div class="flex items-center">
                <a href="{{ route('profile') }}" class="text-xl">Profile</a>
                <a href="{{ route('logout') }}">
                    <img src="{{ asset('assets/svg/Logout.svg') }}" class="w-12" alt="logout">
                </a>
            </div>
        @else
            <a href="{{ route('login') }}" class="text-xl">Login </a>
            /
            <a href="{{ route('register') }}" class="text-xl"> Signup</a>
        @endauth
    </div>
</nav>
