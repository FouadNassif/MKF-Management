<nav class="bg-Primary flex justify-between items-center text-white p-1">
    <a class="flex items-center cursor-pointe" href="/">
        <img src="{{ asset('assets/svg/Logo.svg') }}" alt="">
        <h1 class="font-bold text-2xl">MKF Management</h1>
    </a>
    <div>
        @auth
            <div class="flex items-center text-xl">
                <a href="{{ route('user.cart') }}" class="cart-wrapper relative inline-block">
                    <p id="cartItemsCounter"
                        class="cart-counter absolute bg-cyan-950 text-2xl px-3 rounded-full left-0 top-1 transform -translate-x-1/2 -translate-y-1/2">
                    </p>
                    <img src="{{ asset('assets/svg/Cart.svg') }}" class="w-12" alt="Cart" title="Cart">
                </a>

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