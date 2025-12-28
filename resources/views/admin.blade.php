@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => __('admin.pageTitle'),
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">

        @include('partials.flash')

        {{-- Header + Intro-Text --}}
        <div class="w-full mb-6 md:max-w-3/4 lg:max-w-1/2">
            <h1 class="section-header mb-2">{{ __('admin.pageTitle') }}</h1>
            <p class="text-sm md:text-base mb-2">{{ __('admin.intro') }}</p>
        </div>

        {{-- Create plan button --}}
        <div class="mb-6">
            <a class="icon-button w-auto" href="{{route('plan.create')}}">
                <span>{{ __('admin.buttonAddPlan') }}</span>
                @include('partials.svg.plus')
            </a>
        </div>

        {{-- Plans list --}}
        <div class="w-full md:table md:mt-2">

            {{-- Table header (only md and up) --}}
            <div class="hidden md:table-header-group text-left">
                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('admin.tableHeader.title') }}</div>
                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('admin.tableHeader.timespan') }}</div>
                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('admin.tableHeader.shiftsAmount') }}</div>
                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('admin.tableHeader.teamSize') }}</div>
                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('admin.tableHeader.links') }}</div>
                <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('admin.tableHeader.delete') }}</div>
            </div>

            @foreach($plans as $plan)
                <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                    <div class="align-top md:table-cell mb-2 md:mb-0 md:p-2">
                        <span class="font-bold">{{ $plan->title }}</span>
                    </div>

                    <div class="align-top md:table-cell text-xs lg:text-base mb-2 md:mb-0 md:p-2 whitespace-nowrap">
                        <span>{{ $plan->getTimespan() }}</span>
                    </div>

                    <div class="align-top md:table-cell text-sm lg:text-base mb-2 md:mb-0 md:p-2 whitespace-nowrap">
                        <span class="md:hidden">{{ __('admin.tableHeader.shiftsAmount') }}: </span>
                        <span class="font-bold">{{ $plan->shifts->count() }}</span>
                    </div>

                    <div class="align-top md:table-cell text-sm lg:text-base mb-2 md:mb-0 md:p-2 whitespace-nowrap">
                        <span class="md:hidden">{{ __('admin.tableHeader.teamSize') }}: </span>
                        <span class="font-bold">{{ $plan->getStatistics()->subscriptionsAvailable }}</span>
                    </div>

                    <div class="align-top md:table-cell text-sm lg:text-base mb-2 md:mb-0 md:p-2 whitespace-nowrap">
                        <div class="flex flex-col gap-2">
                            <a class="icon-button w-auto" href="{{route('plan.show', ['plan' => $plan])}}" target="_blank" title="{{ __('admin.linkPublic') }}">
                                <span>{{ __('admin.linkPublic') }}</span>
                                @include('partials.svg.share')
                            </a>
                            <a class="icon-button w-auto" href="{{route('plan.admin', ['plan' => $plan])}}" target="_blank" title="{{ __('admin.linkAdmin') }}">
                                <span>{{ __('admin.linkAdmin') }}</span>
                                @include('partials.svg.pencil')
                            </a>
                            
                        </div>
                    </div>

                    <div class="align-top md:table-cell text-sm lg:text-base mb-2 md:mb-0 md:p-2 whitespace-nowrap">
                        <form method="post" action="{{route('plan.destroy', ['plan' => $plan])}}" class="delete-with-confirm" data-confirm-delete-msg="{{ __('plan.confirmDelete') }}">
                            @method('delete')
                            @csrf
                            <button type="submit" title="{{ __('admin.buttonDeletePlan') }}" class="icon-button big-button red-button no-text w-auto whitespace-nowrap py-1">
                                <span>{{ __('admin.buttonDeletePlan') }}</span>
                                @include('partials.svg.delete')
                            </button type="submit">
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection