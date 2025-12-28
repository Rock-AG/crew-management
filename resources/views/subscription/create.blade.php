@php
    $mode = (isset($subscription->id) && $subscription->id > 0) ? "edit" : "create";
    $pageTitle = __('subscription.pageTitle.' . $mode);

    if ($mode == "edit") {
        $formAction = route('subscription.update', ['plan' => $plan, 'shift' => $shift, 'subscription' => $subscription]);
    } else {
        $formAction = route('subscription.store', ['plan' => $plan, 'shift' => $shift]);
    }
@endphp

@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => $pageTitle,
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">

        {{-- Header / Intro --}}
        <h1 class="section-header mb-2 md:mb-4">{{ __("subscription.headline." . $mode) }}</h1>
        <p class="text-lg md:text-2xl text-center mb-2 md:mb-4">{{ $plan->title }}</p>
        <p class="text-lg md:text-2xl text-center font-bold">{{ $shift->title }}</p>
        <p class="md:text-lg text-center mb-2 md:mb-4">{!! \App\Http\Controllers\PlanController::buildDateString($shift->start, $shift->end, true) !!}</p>
        <p class="text-sm md:text-base text-center italic mb-4 md:mb-8">{{ $shift->description }}</p>

        {{-- Form--}}
        <form action="{{ $formAction }}" method="post">
            @csrf

            @if($mode == "edit")
                @method("put")
            @endif
            
            <div class="md:grid md:grid-cols-2 md:grid-rows-4 md:gap-2 md:mb-2">

                <div class="mb-2 md:mb-0">
                    <label for="nickname" class="block mb-1 text-sm md:text-base">{{__("subscription.nickname")}}</label>
                    <input id="nickname" name="nickname" placeholder="{{__('subscription.nicknameShort')}}" type="text" class="@error('nickname') error @enderror w-full" value="{{ old('nickname', $subscription->nickname) }}">
                    @error('nickname')
                        <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-2 md:mb-0">
                    <label for="name" class="block mb-1 text-sm md:text-base">{{__("subscription.name")}}</label>
                    <input id="name" name="name" placeholder="{{__('subscription.name')}}" type="text" class="@error('name') error @enderror w-full" value="{{ old('name', $subscription->name) }}">
                    @error('name')
                    <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-2 md:mb-0">
                    <label for="phone" class="block mb-1 text-sm md:text-base">{{__("subscription.phone")}}</label>
                    <input id="phone" name="phone" placeholder="{{__('subscription.phone')}}" type="text" class="@error('phone') error @enderror w-full" value="{{ old('phone', $subscription->phone) }}">
                    @error('phone')
                    <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-2 md:mb-0">
                    <label for="email" class="block mb-1 text-sm md:text-base">{{__("subscription.email")}}</label>
                    <input id="email" name="email" placeholder="{{__('subscription.email')}}" type="text" class="@error('email') error @enderror w-full" value="{{ old('email', $subscription->email) }}">
                    @error('email')
                    <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-2 md:mb-0 md:row-span-3 md:col-start-2 md:row-start-1">
                    <label for="comment" class="block mb-1 text-sm md:text-base">{{__("subscription.comment")}}</label>
                    <textarea id="comment" rows="6" name="comment" placeholder="{{__('subscription.comment')}}" class="@error('comment') error @enderror w-full field-sizing-content">{{old('comment', $subscription->comment)}}</textarea>
                    @error('comment')
                        <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Notification checkbox --}}
            {{--
            <div>
                <div class="block mb-2">
                    <input id="notification" name="notification" type="checkbox" value="1" {{ old('notification', $plan->notification) ? 'checked' : '' }} >
                    <label for="notification">{{__("subscription.notification")}}</label>
                    @error('notification')
                        <div class="text-red-700 text-xs italic mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            --}}

            {{-- Privacy text --}}
            @if($mode == "create")
                <div class="mb-2 mt-4">
                    <p class="text-sm">{!! __('subscription.privacyText') !!}</p>
                </div>
            @endif

            {{-- Submit / cancel buttons --}}
            <div class="flex gap-2 mt-4">
                @if($mode == "edit")
                    <button type="submit" class="icon-button">
                        <span>{{__('subscription.buttonEdit')}}</span>
                        @include('partials.svg.save')
                    </button>
                    <a href="{{ route('plan.subscriptions', $plan) }}" class="icon-button">
                        {{__('general.buttonCancel')}}
                        @include('partials.svg.x')
                    </a>
                @else
                    <button type="submit" class="icon-button">
                        <span>{{__('subscription.buttonCreate')}}</span>
                        @include('partials.svg.rock-hand')
                    </button>
                    <a href="{{ route('plan.view.user', $plan) }}" class="icon-button">
                        {{__('general.buttonCancel')}}
                        @include('partials.svg.x')
                    </a>
                @endif
            </div>

        </form>
    </div>
@endsection
