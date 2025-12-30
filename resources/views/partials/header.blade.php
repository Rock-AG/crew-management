<header class="sticky top-0 z-10 mb-4 bg-ci-gray-dark text-ci-white flex flex-row w-full page-header-box-shadow">
    <a href="{{ route('homepage') }}" class="min-w-[28px] m-2 flex flex-col justify-center" title="{{ __('navigation.home') }}">
        @include('partials.svg.home')
    </a>
    @auth
        <a href="{{ route('user.change-password') }}" class="min-w-[28px] m-2 flex flex-col justify-center" title="{{ __('auth.userPreferences') }}">
            @include('partials.svg.user')
        </a>
        <form action="{{ route('logout') }}" method="post" class="flex">
            @csrf
            <button type="submit" class="min-w-[28px] m-2 flex flex-col justify-center cursor-pointer" title="{{ __('auth.logout') }}">
                @include('partials.svg.logout')
            </button>
        </form>
    @else

    @endauth
    <div class="bg-ci-gray-dark text-ci-white w-full p-2 text-right flex flex-col justify-center">
        <span class="[font-variant:small-caps] font-semibold text-lg">{{ $pageTitle }}</span>
    </div>
</header>