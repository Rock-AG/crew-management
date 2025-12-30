@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => __('auth.pageTitle.forgot-password'),
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">

        @include('partials.flash')

        <section class="max-w-md mx-auto text-center">
            <header>
                <h1 class="section-header mb-2">{{ __('auth.headline.forgot-password') }}</h1>
                <p class="mb-2 text-sm md:text-base">{{ __('auth.intro.forgot-password') }}</p>
            </header>

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <div class="">
                    <div class="mb-2 text-left">
                        <label for="email" class="block mb-1 text-sm md:text-base">{{__("auth.email")}}</label>
                        <input id="email" name="email" placeholder="{{__('auth.email')}}" type="text" class="@error('email') error @enderror w-full" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-baseline justify-between">
                        <button type="submit" class="icon-button mt-4">
                            <span>{{__('auth.buttonRequestResetLink')}}</span>
                            @include('partials.svg.send')
                        </button>

                        <a class="textlink" href="{{ route('login') }}">{{__('auth.linkLogin')}}</a>
                    </div>
                    
                </div>
            </form>
        </section>
        
    
    </div>
@endsection
