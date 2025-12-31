@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => __('plan.pageTitle.duplicate'),
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">

        @include('partials.flash')

        {{-- Header --}}
        <div class="w-full mb-6 md:mb-12 md:max-w-3/4 lg:max-w-1/2">
            <h1 class="section-header mb-2">{{ __("plan.headline.duplicate") }}</h1>
            <p class="text-sm md:text-base mb-2">{{ __('plan.intro.duplicate', ['planTitle' => $plan->title]) }}</p>
        </div>

        <form action="{{ route('plan.duplicate.store', ['plan' => $plan]) }}" method="post">
            @csrf
            @method('PUT')

            <div class="md:table w-full mb-6 md:mb-12">
                <div class="hidden md:table-header-group text-left">
                    <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd w-1">{{ __('admin.tableHeader.valueName') }}</div>
                    <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('admin.tableHeader.valueCopy') }}</div>
                    <div class="table-cell italic text-sm whitespace-nowrap p-1 px-2 bg-table-odd">{{ __('admin.tableHeader.valueBase') }}</div>
                </div>

                <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                    <div class="md:table-cell align-top md:p-2 md:pt-4">
                        <label for="title" class="block mb-1 text-sm md:text-base">{{__("plan.title")}}</label>
                    </div>
                    <div class="md:table-cell md:min-w-[50%] md:p-2">
                        <input id="title" name="title" placeholder="{{__('plan.title')}}" type="text" class="@error('title') error @enderror w-full" value="{{ old('title', $plan->title . ' (Copy)') }}">
                        @error('title')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:table-cell align-top pt-2 md:p-2 md:pt-4 text-xs md:text-base">
                        <span class="md:hidden">{{ __('admin.tableHeader.valueBase') }}: </span>
                        <span class="italic md:not-italic">{{ $plan->title }}</span>
                    </div>
                </div>

                <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                    <div class="md:table-cell align-top md:p-2 md:pt-4">
                        <label for="description" class="block mb-1 text-sm md:text-base">{{__("plan.planDesc")}}</label>
                    </div>
                    <div class="md:table-cell md:min-w-[50%] md:p-2">
                        <textarea id="description" rows="5" name="description" placeholder="{{__('plan.planDesc')}}" class="@error('description') error @enderror w-full field-sizing-content">{{old('description', $plan->description)}}</textarea>
                        @error('description')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:table-cell align-top pt-2 md:p-2 md:pt-4 text-xs md:text-base">
                        <span class="md:hidden">{{ __('admin.tableHeader.valueBase') }}: </span>
                        <span class="italic md:not-italic">{{ $plan->description }}</span>
                    </div>
                </div>

                <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                    <div class="md:table-cell align-top md:p-2 md:pt-4">
                        <label for="event_date" class="block mb-1 text-sm md:text-base">{{__("plan.event_date")}}</label>
                    </div>
                    <div class="md:table-cell md:min-w-[50%] md:p-2">
                        <input id="event_date" name="event_date" placeholder="{{__('plan.event_date')}}" type="text" class="datepicker @error('event_date') error @enderror w-full" value="{{ old('event_date') }}">
                        @error('event_date')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:table-cell align-top pt-2 md:p-2 md:pt-4 text-xs md:text-base">
                        <span class="md:hidden">{{ __('admin.tableHeader.valueBase') }}: </span>
                        <span class="italic md:not-italic">{{ $plan->event_date->translatedFormat('d. F Y') }}</span>
                    </div>
                </div>

                <div class="md:table-row odd:bg-table-odd even:bg-table-even p-2">
                    <div class="md:table-cell align-top md:p-2 md:pt-4">
                        <label for="contact" class="block mb-1 text-sm md:text-base">{{__("plan.contactDesc")}}</label>
                    </div>
                    <div class="md:table-cell md:min-w-[50%] md:p-2">
                        <input id="contact" name="contact" placeholder="{{__('plan.contactDesc')}}" type="text" class="@error('contact') error @enderror w-full" value="{{ old('contact', $plan->contact) }}">
                        @error('contact')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="md:table-cell align-top pt-2 md:p-2 md:pt-4 text-xs md:text-base">
                        <span class="md:hidden">{{ __('admin.tableHeader.valueBase') }}: </span>
                        <span class="italic md:not-italic">{{ $plan->contact }}</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="icon-button big-button">
                <span>{{__('admin.buttonSaveDuplicate')}}</span>
                @include('partials.svg.save')
            </button>
        </form>
    </div>
@endsection