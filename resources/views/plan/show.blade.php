@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => $plan->title
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">

        @include('partials.flash')

        {{-- Header + Intro-Text --}}
        <div class="w-full md:mt-6 mb-6 md:mb-12 md:mx-auto md:max-w-3/4 lg:max-w-1/2 md:text-center">
            <h1 class="section-header mb-2">{{ $plan->title }}</h1>
            <p class="text-sm md:text-base mb-2">{{ $plan->description }}</p>
            <p class="text-sm md:text-base mb-2">{{ $plan->contact }}</p>
        </div>

        {{-- Shifts grouped by type --}}
        <div class="accordion-container mb-4">
            @foreach($shiftsGroupedByCategory as $category => $shifts)
                <div class="ac group mb-2 md:mb-4">

                    <h3 class="ac-header flex">
                        <button type="button" class="ac-trigger flex gap-2 grow items-center py-2 border-b-ci-white border-b-1 cursor-pointer text-left">
                            <span class="text-lg md:text-2xl font-semibold">{{ $category }}</span>
                            <span class="text-base md:text-lg whitespace-nowrap">({{ trans_choice('plan.shiftsPluralized', $shifts->count()) }})</span>
                            <span class="group-[.is-active]:rotate-180 ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg>
                            </span>
                        </button>
                    </h3>

                    {{-- <h3 class="text-lg md:text-2xl font-semibold p-2 border-b-ci-white border-b-1">{{ $category }}</h3> --}}

                    <div class="ac-panel overflow-hidden">

                        <div class="w-full md:table text-xs md:text-sm lg:text-base">

                            <div class="hidden md:table-header-group">
                                <div class="table-cell italic text-sm whitespace-nowrap bg-table-odd p-2">{{ __('shift.titleDescription') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap bg-table-odd p-2">{{ __('shift.dateTime') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap bg-table-odd w-1 p-2">{{ __('shift.action') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap bg-table-odd p-2 text-center">{{ __('shift.subscriptionsDesc') }}</div>
                            </div>

                            @foreach($shifts as $shift)
                                <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">

                                    <div class="align-top md:table-cell text-sm lg:text-base mb-2 md:mb-0 md:p-2">
                                        <span class="font-bold">{{ $shift->title }}</span>
                                        <p class="text-xs md:text-sm">{{ $shift->description }}</p>
                                    </div>

                                    <div class="align-top md:table-cell mb-2 md:mb-0 md:p-2 whitespace-nowrap">
                                        <span class="italic md:not-italic">{!! \App\Http\Controllers\PlanController::buildDateString($shift->start, $shift->end) !!}</span>
                                    </div>

                                    <div class="align-top md:table-cell">
                                        <div class="flex flex-row md:flex-col justify-start text-right gap-2 mt-2 md:m-2">

                                            {{-- Subscribe --}}
                                            @if ($plan->allow_subscribe && $shift->team_size > $shift->subscriptions->count())
                                                <a class="icon-button w-auto" href="{{route('plan.subscription.create', ['plan' => $shift->plan->view_id, 'shift'=> $shift])}}">
                                                    <span>{{ __('shift.subscribe') }}</span>
                                                    @include('partials.svg.rock-hand')
                                                </a>
                                            @endif

                                            {{-- Unsubscribe --}}
                                            @if ($plan->allow_unsubscribe && strtotime($shift->start) > strtotime('+2 day') && $shift->subscriptions->count() > 0)
                                                <a class="icon-button w-auto" href="{{route('plan.subscription.remove', ['plan' => $shift->plan->view_id, 'shift'=> $shift])}}">
                                                    <span>{{ __('shift.unsubscribe') }}</span>
                                                    @include('partials.svg.frown')
                                                </a>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="align-middle mt-2 md:table-cell md:p-2 whitespace-nowrap md:text-center">
                                        <span class="font-bold">{{ $shift->subscriptions->count() }}&nbsp;/&nbsp;{{ $shift->team_size }}</span>
                                        <span class="md:hidden font-bold">{{ __('shift.subscriptionsDesc') }}</span><br>
                                        @foreach($shift->subscriptions as $subscription)
                                            {{$subscription->nickname}}
                                            @if($subscription != $shift->subscriptions->last())<br> @endif
                                        @endforeach
                                    </div>

                                    
                                    
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endsection
