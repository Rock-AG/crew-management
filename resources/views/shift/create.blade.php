@php
    $mode = (\Illuminate\Support\Facades\Route::currentRouteName() == "plan.shift.edit") ? "edit" : "create";

    if ($mode == "edit") {
        $pageTitle = $shift->title . " (Bearbeiten)";
        $formAction = route('plan.shift.update', ['plan' => $plan, 'shift' => $shift]);
    } else {
        $pageTitle = "Neue Schicht erstellen";
        $formAction = route('plan.shift.store', ['plan' => $plan]);
    }
@endphp

@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => $pageTitle,
])

@section('body')
    
    <div class="max-w-full mx-2 mb-4 flex-1">

        {{-- Header --}}
        <h1 class="section-header mb-2">{{ __("shift.headline." . $mode) }}</h1>

        <form action="{{ $formAction }}" method="post">
            @csrf

            @if($mode == "edit")
                @method("put")
            @endif

            <input id="group" name="group" type="hidden" value="0">

            <div class="md:grid md:grid-cols-2 md:grid-rows-2 md:gap-2 mb-2">

                <div class="mb-2 md:mb-0">
                    <label for="title" class="block mb-1 text-sm md:text-base">{{__("shift.title")}}</label>
                    <input id="title" name="title" placeholder="{{__('shift.title')}}" type="text" class="@error('title') error @enderror w-full" value="{{ old('title', $shift->title) }}">
                    @error('title')
                        <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 md:mb-0 md:row-span-5">
                    <label for="description" class="block mb-1 text-sm md:text-base">{{__("shift.description")}}</label>
                    <textarea id="description" rows="5" name="description" placeholder="{{__('shift.description')}}" class="@error('description') error @enderror w-full field-sizing-content">{{old('description', $shift->description)}}</textarea>
                    @error('description')
                        <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="md:flex md:gap-2">
                    <div class="mb-2 md:mb-0 md:flex-1">
                        <label for="start" class="block mb-1 text-sm md:text-base">{{__("shift.startDesc")}}</label>
                        <input id="start" name="start" placeholder="{{__('shift.startDesc')}}" type="text" class="datepicker @error('start') error @enderror w-full" value="{{ old('start', $shift->start) }}">
                        @error('start')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2 md:mb-0 md:flex-1">
                        <label for="end" class="block mb-1 text-sm md:text-base">{{__("shift.endDesc")}}</label>
                        <input id="end" name="end" placeholder="{{__('shift.endDesc')}}" type="text" class="datepicker @error('end') error @enderror w-full" value="{{ old('end', $shift->end) }}">
                        @error('end')
                            <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-2 md:mb-0">
                    <label for="team_size" class="block mb-1 text-sm md:text-base">{{__("shift.team_sizeDesc")}}</label>
                    <input id="team_size" name="team_size" placeholder="{{__('shift.team_sizeDesc')}}" type="number" class="@error('team_size') error @enderror w-full" value="{{ old('team_size', $shift->team_size) }}">
                    @error('team_size')
                        <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 md:mb-0">
                    <label for="category" class="block mb-1 text-sm md:text-base">{{__("shift.category")}}</label>
                    <input id="category" name="category" placeholder="{{__('shift.category')}}" type="text" class="@error('category') error @enderror w-full" value="{{ old('category', $shift->category) }}">
                    @error('category')
                        <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="accordion-container mb-2">
                    <div class="ac group">

                        <h3 class="ac-header flex">
                            <button type="button" class="ac-trigger flex justify-left grow relative items-center py-2 border-b-ci-white border-b-1 cursor-pointer font-semibold lg:text-lg">
                                <span class="text-left w-full">{{ __('shift.contact_info_header') }}</span>
                                <span class="group-[.is-active]:rotate-180 ml-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg>
                                </span>
                            </button>
                        </h3>

                        <div class="ac-panel overflow-hidden">

                            <div class="my-2">
                                <label for="contact_name" class="block mb-1 text-sm md:text-base">{{__("shift.contact_name")}}</label>
                                <input id="contact_name" name="contact_name" placeholder="{{__('shift.contact_name')}}" type="text" class="@error('contact_name') error @enderror w-full" value="{{ old('contact_name', $shift->contact_name) }}">
                                @error('contact_name')
                                    <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="md:flex md:gap-2">
                                <div class="mb-2 md:mb-0 md:flex-1">
                                    <label for="contact_email" class="block mb-1 text-sm md:text-base">{{__("shift.contact_email")}}</label>
                                    <input id="contact_email" name="contact_email" placeholder="{{__('shift.contact_email')}}" type="text" class="@error('contact_email') error @enderror w-full" value="{{ old('contact_email', $shift->contact_email) }}">
                                    @error('contact_email')
                                        <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-2 md:mb-0 md:flex-1">
                                    <label for="contact_phone" class="block mb-1 text-sm md:text-base">{{__("shift.contact_phone")}}</label>
                                    <input id="contact_phone" name="contact_phone" placeholder="{{__('shift.contact_phone')}}" type="text" class="@error('contact_phone') error @enderror w-full" value="{{ old('contact_phone', $shift->contact_phone) }}">
                                    @error('contact_phone')
                                        <div class="text-red-700 text-xs italic mt-2 pl-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="">
                <button type="submit" class="icon-button">
                    <span>{{__('general.buttonSave')}}</span>
                    @include('partials.svg.save')
                </button>

                <a href="{{ route('plan.view.admin', $plan) }}" class="icon-button">
                    {{__('general.buttonCancel')}}
                    @include('partials.svg.x')
                </a>
            </div>
            
        </form>
    </div>

@endsection
