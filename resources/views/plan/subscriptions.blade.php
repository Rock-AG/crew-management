@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => $plan->title . ' (Helfer*innen)'
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">
        @include('partials.flash')

        {{-- Header + Intro-Text --}}
        <div class="w-full mb-6 md:mb-12 md:max-w-3/4 lg:max-w-1/2">
            <h1 class="section-header mb-2">
                {{ __('plan.planAdminSubscriptionsTitle') }}
                <span class="font-open-sans text-xl md:text-2xl">({{ $plan->title }})</span>
            </h1>
            <p class="text-sm md:text-base mb-2">{{ __('plan.planAdminSubscriptionsIntro') }}</p>
            
            <p>
                <a href="{{route('plan.view.admin', ['plan' => $plan])}}" class="icon-button w-auto whitespace-nowrap">
                    <span>{{ __('general.buttonBack') }}</span>
                    @include('partials.svg.arrow-left')
                </a>
            </p>
        </div>

        {{-- Search --}}
        <div class="w-full mb-2">
            <p class="mb-2 font-bold">{{ __('shift.searchFormIntro') }}</p>
            <form action="{{ url()->full() }}" method="GET">
                @if(request()->get('orderBy', ''))
                    <input type="hidden" name="orderBy" value="{{ request()->get('orderBy', '') }}">
                @endif
                <div class="w-full md:max-w-3/4 lg:max-w-1/2 flex gap-2 flex-wrap items-center">
                    <div class="flex-2">
                        <input id="search" name="search" type="text" class="w-full min-w-3xs" value="{{ request()->get('search', '') }}" placeholder="Suchbegriff">
                    </div>
                    <div class="">
                        <button type="submit" class="icon-button w-auto whitespace-nowrap py-1">
                            <span>{{ __('shift.searchButton') }}</span>
                            @include('partials.svg.search')
                        </button type="submit">
                    </div>
                    @if(request()->get('search', ''))
                        <div class="flex-1">
                            <a href="{{ route('plan.subscriptions', ['plan' => $plan, 'orderBy' => request()->get('orderBy', ''), 'search' => '']) }}" class="icon-button w-auto whitespace-nowrap py-1">
                                <span>{{ __('shift.clearSearchButton') }}</span>
                                @include('partials.svg.x')
                            </a>
                        </div>
                    @endif
                </div>
            </form>
        </div>

        {{-- Sorting --}}
        <div class="w-full mb-6 md:mb-12">
            <p class="mb-2 font-bold">{{ __('shift.orderByButtonsIntro') }}</p>
            <div class="w-full flex gap-2 flex-wrap">
                <a href="{{route('plan.subscriptions', ['plan' => $plan, 'orderBy' => 'title', 'search' => request()->get('search', '')])}}" class="icon-button w-auto whitespace-nowrap">
                    <span>{{ __('shift.orderByTitle') }}</span>
                    @include('partials.svg.text')
                </a>
                <a href="{{route('plan.subscriptions', ['plan' => $plan, 'orderBy' => 'start', 'search' => request()->get('search', '')])}}" class="icon-button w-auto whitespace-nowrap">
                    <span>{{ __('shift.orderByStart') }}</span>
                    @include('partials.svg.calendar')
                </a>
                {{-- 
                <a href="{{route('plan.subscriptions', ['plan' => $plan, 'orderBy' => 'type', 'search' => request()->get('search', '')])}}" class="icon-button w-auto whitespace-nowrap">
                    <span>{{ __('shift.orderByType') }}</span>
                    @include('partials.svg.tags')
                </a>
                --}}
            </div>
        </div>

        
        @if(count($shifts) == 0)

            {{-- "No shifts" text --}}
            <div class="w-full mb-6 md:mb-12 md:max-w-3/4 lg:max-w-1/2">
                <p class="italic">
                    @if(request()->get('search', ''))
                        {{__('shift.noshiftsFromSearch')}}
                    @else
                        {{__('shift.noshifts')}}
                    @endif
                </p>
            </div>
        @else

            {{-- Shifts list --}}
            @foreach($shifts as $shift)
                <div class="md:mb-2 overflow-x-auto">

                    {{-- Header: Shift percentage, title, date/time --}}
                    <div class="flex flex-wrap gap-2 justify-left grow relative items-center py-2 font-semibold lg:text-lg">
                        <div class="md:inline">
                            <span class="rounded font-bold p-2 percentage-{{ ($shift->getSubscriptionsPercentage()) }} text-ci-black">
                                {{$shift->subscriptions->count()}} / {{$shift->team_size}}
                            </span>
                        </div>
                        <div class="flex-9 @if(count($shift->subscriptions) == 0) [opacity:0.4] @endif">
                            <span class="block md:inline-block text-left text-md md:text-lg">{{ $shift->title }}</span>
                            <span class="block md:inline-block text-left text-xs md:text-sm whitespace-nowrap">({{ $shift->getTimespan() }})</span>
                        </div>
                        <div class="@if(count($shift->subscriptions) == 0) hidden @endif">
                            <button type="submit" class="icon-button w-auto whitespace-nowrap js-copy-text" data-text="{{ $shift->getSubscriptionsEmailString() }}" data-success-text="{{ __('shift.copyEmailsSuccess') }}">
                                <span>{{ __('shift.copyEmails') }}</span>
                                @include('partials.svg.copy')
                            </a>    
                        
                        </div>
                    </div>

                    @if(count($shift->subscriptions) > 0)

                        {{-- Table: Shift subscriptions --}}
                        <div class="w-full md:table md:mt-2">

                            {{-- Table header (only md and up) --}}
                            <div class="hidden md:table-header-group text-left">
                                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('subscription.nickname') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('subscription.fullName') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('subscription.email') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('subscription.phone') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('subscription.comment') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('general.actions') }}</div>
                            </div>

                            {{-- Subscriptions list --}}
                            @foreach($shift->subscriptions as $subscription)
                                <div class="grid grid-cols-[1fr_40px] grid-rows-1 gap-1 md:table-row p-2 odd:bg-table-odd even:bg-table-even">
                                    <div class="md:table-cell md:p-1 md:px-2 align-middle font-bold">
                                        {{ $subscription->nickname }}
                                    </div>
                                    <div class="md:table-cell md:p-1 md:px-2 align-middle text-xs md:text-base">
                                        {{ $subscription->name }}
                                    </div>
                                    <div class="md:table-cell md:p-1 md:px-2 align-middle text-xs md:text-base">
                                        <a class="textlink" href="mailto:{{ $subscription->email }}">{{ $subscription->email }}</a>
                                    </div>
                                    <div class="md:table-cell md:p-1 md:px-2 align-middle text-xs md:text-base">
                                        <a class="textlink" href="tel:{{ $subscription->phone }}">{{ $subscription->phone }}</a>
                                    </div>
                                    <div class="md:table-cell md:p-1 md:px-2 align-middle text-xs md:text-base">
                                        {{ $subscription->comment }}
                                    </div>
                                    <div class="row-span-5 row-start-1 col-start-2 md:table-cell md:w-[106px] md:min-w-[106px]">
                                        <div class="flex flex-wrap gap-2 md:gap-2 md:p-2">
                                            <a class="icon-button no-text w-auto" title="{{ __('shift.editSubscription') }}" href="{{route('subscription.edit',  ['plan' => $plan, 'shift' => $shift, 'subscription' => $subscription])}}">
                                                <span>{{ __('shift.editSubscription') }}</span>
                                                @include('partials.svg.pencil')
                                            </a>
                                            <form method="post" action="{{route('subscription.destroy', ['plan' => $plan, 'shift' => $shift, 'subscription' => $subscription])}}" class="delete-with-confirm" data-confirm-delete-msg="{{ __('shift.confirmDeleteSubscription') }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" title="{{ __('shift.deleteSubscription') }}" class="icon-button no-text w-auto whitespace-nowrap py-1">
                                                    <span>{{ __('shift.deleteSubscription') }}</span>
                                                    @include('partials.svg.x')
                                                </button type="submit">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        

                    @endif
                    
                </div>
            @endforeach

        @endif
        
        <p class="mt-6 md:mt-12">
            <a href="{{route('plan.view.admin', ['plan' => $plan])}}" class="icon-button w-auto whitespace-nowrap">
                <span>{{ __('general.buttonBack') }}</span>
                @include('partials.svg.arrow-left')
            </a>
        </p>

    </div>
@endsection
