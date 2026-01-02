@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => $plan->title . __('plan.pageTitle.adminSuffix'),
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">

        @include('partials.flash')

        {{-- Header + Intro-Text --}}
        <div class="w-full mb-6 md:mb-12 md:max-w-3/4 lg:max-w-1/2">
            <h1 class="section-header mb-2">{{ __('plan.planAdminTitle') }}</h1>
            <p class="text-sm md:text-base mb-2">{{ __('plan.planAdminIntro') }}</p>
            <p class="text-sm md:text-base mb-2">{{ __('plan.planAdminIntroLinkDescription') }}</p>
            
            <div class="flex flex-col md:flex-row gap-2 md:items-center">
                <input class="md:flex-3" type="text" id="plan-view-link" readonly aria-readonly="true" value="{{route('plan.view.user', ['plan' => $plan])}}">
                <div>
                    <button type="submit" class="icon-button w-auto whitespace-nowrap js-copy-link" title="{{ __('plan.copyLink') }}" data-input-id="plan-view-link" data-success-text="{{ __('plan.copyLinkSuccess') }}">
                        <span>{{ __('plan.copyLink') }}</span>
                        @include('partials.svg.copy')
                    </button>
                </div>
            </div>
        </div>
        
        <div class="lg:grid lg:grid-cols-2 lg:gap-4">

            <div>

                {{-- Basic settings --}}
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <h2 class="section-header">{{ __('plan.planAdminBasicSettingsTitle') }}</h2>
                    <div>
                        <a class="icon-button w-auto" href="{{route('plan.edit', ['plan' => $plan])}}" title="{{ __('plan.editSettings') }}">
                            <span>{{ __('plan.editSettings') }}</span>
                            @include('partials.svg.pencil')
                        </a>
                    </div>
                </div>
                <div class="md:table md:max-w-3/4 lg:max-w-full mb-6 md:mb-12">
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell md:min-w-[30%] text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.title') }}</div>
                        <div class="md:table-cell md:p-2">{{ $plan->title }}</div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell md:min-w-[30%] text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.event_date') }}</div>
                        <div class="md:table-cell md:p-2">{{ $plan->event_date->translatedFormat('d. F Y') }}</div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell md:min-w-[30%] text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.planDesc') }}</div>
                        <div class="md:table-cell md:p-2">{{ $plan->description }}</div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell md:min-w-[30%] text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.contactDesc') }}</div>
                        <div class="md:table-cell md:p-2">{{ $plan->contact }}</div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell md:min-w-[30%] text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.showOnHomepage') }}</div>
                        <div class="md:table-cell md:p-2">
                            <div class="w-6 mt-1 md:m-0">
                                @include('partials.svg.' . ($plan->show_on_homepage == 1 ? 'checkmark' : 'cross'))
                            </div>
                        </div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell md:min-w-[30%] text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.allowSubscribe') }}</div>
                        <div class="md:table-cell md:p-2">
                            <div class="w-6 mt-1 md:m-0">
                                @include('partials.svg.' . ($plan->allow_subscribe == 1 ? 'checkmark' : 'cross'))
                            </div>
                        </div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell md:min-w-[30%] text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.allowUnsubscribe') }}</div>
                        <div class="md:table-cell md:p-2">
                            <div class="w-6 mt-1 md:m-0">
                                @include('partials.svg.' . ($plan->allow_unsubscribe == 1 ? 'checkmark' : 'cross'))
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div>

                {{-- Subscription overview + link --}}
                <div class="flex flex-wrap items-center gap-2 mb-2">
                    <h2 class="section-header">{{ __('plan.planAdminSubscriptionsTitle') }}</h2>
                    <div>
                        <a class="icon-button w-auto" href="{{route('plan.subscriptions', ['plan' => $plan])}}" title="{{ __('plan.show_edit_subscriptions_link') }}">
                        <span>{{ __('plan.show_edit_subscriptions_link') }}</span>
                        @include('partials.svg.pencil')
                    </a>
                    </div>
                </div>
                <div class="md:table md:max-w-3/4 lg:max-w-full mb-6 md:mb-12">
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell whitespace-nowrap text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.statistics.subscriptionsAvailable') }}</div>
                        <div class="md:table-cell font-bold md:text-right md:p-2 md:px-4">{{ $plan->getStatistics()->subscriptionsAvailable }}</div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell whitespace-nowrap text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.statistics.subscriptionsFull') }}</div>
                        <div class="md:table-cell font-bold md:text-right md:p-2 md:px-4">{{ $plan->getStatistics()->subscriptionsFull }}</div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell whitespace-nowrap text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.statistics.shiftsFull') }}</div>
                        <div class="md:table-cell font-bold md:text-right md:p-2 md:px-4">{{ $plan->getStatistics()->shiftsFull }}</div>
                    </div>
                    <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                        <div class="md:table-cell whitespace-nowrap text-xs md:text-base align-top font-bold md:p-2">{{ __('plan.statistics.shiftsAvailable') }}</div>
                        <div class="md:table-cell font-bold md:text-right md:p-2 md:px-4">{{ $plan->getStatistics()->shiftsAvailable }}</div>
                    </div>
                </div>

            </div>

        </div>

        {{-- Shifts header --}}
        <h2 class="section-header mb-2">{{ __('plan.planAdminShiftsTitle') }}</h2>
        <p class="text-sm lg:text-base mb-4">{{ __('plan.planAdminShiftsIntro') }}</p>
        <p class="mb-4">
            <a class="icon-button w-auto" href="{{route('plan.shift.create', ['plan' => $plan])}}" title="{{ __('plan.addShift') }}">
                <span>{{ __('plan.addShift') }}</span>
                @include('partials.svg.plus')
            </a>
        </p>

        {{-- Shifts grouped by type --}}
        <div class="accordion-container mb-4">
            @foreach($plan->shiftsGroupedByCategory() as $category => $shifts)
                <div class="ac group mb-2 md:mb-4">

                    <h3 class="ac-header flex">
                        <button type="button" class="ac-trigger flex justify-left grow relative items-center py-2 border-b-ci-white border-b-1 cursor-pointer font-semibold lg:text-lg">
                            <span class="text-left w-full">{{ $category }}</span>
                            <span class="px-1">({{ $shifts->count() }})</span>
                            <span class="group-[.is-active]:rotate-180 ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg>
                            </span>
                        </button>
                    </h3>

                    <div class="ac-panel overflow-hidden">

                        <div class="w-full md:table text-xs md:text-sm lg:text-base">

                            <div class="hidden md:table-header-group">
                                <div class="table-cell italic text-sm whitespace-nowrap bg-table-odd p-2">{{ __('shift.titleDescription') }}</div>
                                <div class="hidden lg:table-cell italic text-sm whitespace-nowrap bg-table-odd p-2">{{ __('shift.contactInfo') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap bg-table-odd p-2">{{ __('shift.dateTime') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap bg-table-odd p-2">{{ __('shift.team_sizeShort') }}</div>
                                <div class="table-cell italic text-sm whitespace-nowrap bg-table-odd w-1 p-2">{{ __('general.actions') }}</div>
                            </div>

                            @foreach($shifts as $shift)
                                <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">

                                    <div class="align-top md:table-cell text-sm lg:text-base mb-2 md:mb-0 md:p-2">
                                        <span class="font-bold">{{ $shift->title }}</span>
                                        <p class="text-xs md:text-sm">{{ $shift->description }}</p>
                                        @if($shift->hasContactInfo())
                                            <p class="lg:hidden mt-2 text-xs md:text-sm">
                                                {{ __('shift.contactInfo') }}: {{ $shift->getContactInfo() }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="align-top hidden lg:table-cell mb-2 md:mb-0 md:p-2">
                                        @if($shift->contact_name)
                                            <p class="">{{ $shift->contact_name }}</p>
                                        @endif
                                        @if($shift->contact_email)
                                            <p class="italic text-sm">{{ $shift->contact_email }}</p>
                                        @endif
                                        @if($shift->contact_phone)
                                            <p class="italic text-sm">{{ $shift->contact_phone }}</p>
                                        @endif
                                    </div>

                                    <div class="align-top md:table-cell mb-2 md:mb-0 md:p-2 whitespace-nowrap">
                                        <span>{!! \App\Http\Controllers\PlanController::buildDateString($shift->start, $shift->end) !!}</span>
                                    </div>
                                    
                                    <div class="align-top md:table-cell md:p-2 whitespace-nowrap">
                                        <span>{{ trans_choice('shift.personsPluralized', $shift->team_size) }}</span>
                                    </div>

                                    <div class="align-top md:table-cell">
                                        <div class="flex flex-row md:flex-col justify-start text-right gap-2 mt-2 md:m-2">

                                            <a class="icon-button w-auto" href="{{route('plan.shift.edit',  ['plan' => $plan, 'shift' => $shift])}}" title="{{ __('general.buttonEdit') }}">
                                                <span>{{ __('general.buttonEdit') }}</span>
                                                @include('partials.svg.pencil')
                                            </a>
                                            <form method="post" action="{{route('plan.shift.destroy', ['plan' => $plan, 'shift' => $shift])}}" class="delete-with-confirm" data-confirm-delete-msg="{{ __('shift.confirmDelete') }}">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="icon-button w-auto" title="{{ __('general.buttonDelete') }}">
                                                    <span>{{ __('general.buttonDelete') }}</span>
                                                    @include('partials.svg.delete')
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                    
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            @endforeach
        </div>

        <p class="mb-4">
            <a class="icon-button w-auto" href="{{route('plan.shift.create', ['plan' => $plan])}}" title="{{ __('plan.addShift') }}">
                <span>{{ __('plan.addShift') }}</span>
                @include('partials.svg.plus')
            </a>
        </p>
    </div>
@endsection
