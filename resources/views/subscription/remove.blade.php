@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => 'Absagen (' . $shift->title . ')',
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">
        {{-- Header + Intro-Text --}}
        <div class="w-full mb-6 md:mb-12 md:max-w-1/2 md:mx-auto md:text-center">
            <h1 class="section-header mb-2">{{ __('subscription.remove.title') }}</h1>
            <p class="text-sm md:text-base mb-2">{{ __('subscription.remove.intro') }}</p>
            
        </div>

        <div class="mb-6 md:mb-12">
            <p class="text-sm md:text-base md:text-center font-bold mb-6 md:mb-12">{{ __('subscription.remove.shiftInfoIntro') }}</p>
            <p class="md:text-lg md:text-center font-bold">{{ $shift->title }}</p>
            <p class="text-sm md:text-base italic md:text-center">({{ $plan->title }})</p>
            <p class="text-sm md:text-lg md:text-center">{!! \App\Http\Controllers\PlanController::buildDateString($shift->start, $shift->end, true) !!}</p>
        </div>

        <div class="w-full mb-6 md:mb-12 md:max-w-1/2 md:mx-auto md:text-center">
            <form method="post" action="{{route('subscription.doRemove', [$plan, $shift])}}">
                @csrf

                <div class="flex flex-col md:flex-row md:items-start gap-2 mb-12">
                    <div class="md:flex-3">
                        <input id="email" name="email" placeholder="{{__('subscription.email')}}" type="text" class="@error('email') error @enderror w-full" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-left text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:flex-1">
                        <button type="submit" class="icon-button w-full" title="{{__('subscription.buttonUnsubscribe')}}">
                            <span>{{__('subscription.buttonUnsubscribe')}}</span>
                            @include('partials.svg.frown')
                        </button>
                    </div>
                </div>

                
                <div class="mb-2">
                    <a href="{{ route('plan.view.user', $plan) }}" class="icon-button" title="{{__('general.buttonBack')}}">
                        {{__('general.buttonBack')}}
                        @include('partials.svg.arrow-left')
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
