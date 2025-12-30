@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => __('auth.pageTitle.change-password'),
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">

        @include('partials.flash')

        <section class="max-w-md mx-auto text-center">
            <header>
                <h1 class="section-header mb-2">{{ __('auth.headline.change-password') }}</h1>
            </header>

            <form action="{{ route('user-password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="">
                    <div class="mb-2 text-left">
                        <label for="email" class="block mb-1 text-sm md:text-base">{{__("auth.email")}}</label>
                        <input readonly id="email" name="email" placeholder="{{__('auth.email')}}" type="text" class="@error('email') error @enderror w-full" value="{{ Auth::user()->email }}">
                        @error('email')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2 text-left">
                        <label for="current_password" class="block mb-1 text-sm md:text-base">{{__("auth.current_password")}}</label>
                        <input id="current_password" name="current_password" placeholder="{{__('auth.current_password')}}" type="password" class="@error('current_password', 'updatePassword') error @enderror w-full" value="">
                        @error('current_password', 'updatePassword')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2 text-left">
                        <label for="password" class="block mb-1 text-sm md:text-base">{{__("auth.password_new")}}</label>
                        <input id="password" name="password" placeholder="{{__('auth.password_new')}}" type="password" class="@error('password') error @enderror w-full" value="">
                        @error('password', 'updatePassword')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2 text-left">
                        <label for="password_confirmation" class="block mb-1 text-sm md:text-base">{{__("auth.password_confirmation")}}</label>
                        <input id="password_confirmation" name="password_confirmation" placeholder="{{__('auth.password_confirmation')}}" type="password" class="@error('password_confirmation') error @enderror w-full" value="">
                        @error('password_confirmation', 'updatePassword')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-baseline justify-between">
                        <button type="submit" class="icon-button mt-4">
                            <span>{{__('auth.buttonChangePassword')}}</span>
                            @include('partials.svg.save')
                        </button>
                    </div>
                    
                </div>
            </form>
        </section>
        
    
    </div>
@endsection
