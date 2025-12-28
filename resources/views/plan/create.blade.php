@php
    $mode = (isset($plan->id) && $plan->id > 0) ? "edit" : "create";

    if ($mode == "edit") {
        $pageTitle = $plan->title . " (Grundeinstellungen)";
        $formAction = route('plan.update', ['plan' => $plan]);
    } else {
        $pageTitle = "Neuen Schichtplan erstellen";
        $formAction = route('plan.store');
    }
@endphp

@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => $pageTitle,
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">

        {{-- Header --}}
        <h1 class="section-header mb-2">{{ __("plan.heading_" . $mode) }}</h1>

        {{-- Form--}}
        <form action="{{ $formAction }}" method="post">
            @csrf

            @if($mode == "edit")
                @method("put")
            @endif

            <div class="md:grid md:grid-cols-2 md:grid-rows-3 md:gap-2 md:mb-2">
                <div class="mb-2 md:mb-0">
                    <label for="title" class="block mb-1 text-sm md:text-base">{{__("plan.title")}}</label>
                    <input id="title" name="title" placeholder="{{__('plan.title')}}" type="text" class="@error('title') error @enderror w-full" value="{{ old('title', $plan->title) }}">
                    @error('title')
                        <div class="text-red-700 text-xs italic pl-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 md:mb-0 md:row-span-3">
                    <label for="description" class="block mb-1 text-sm md:text-base">{{__("plan.planDesc")}}</label>
                    <textarea id="description" rows="5" name="description" placeholder="{{__('plan.planDesc')}}" class="@error('description') error @enderror w-full field-sizing-content">{{old('description', $plan->description)}}</textarea>
                    @error('description')
                        <div class="text-red-700 text-xs italic pl-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 md:mb-0">
                    <label for="contact" class="block mb-1 text-sm md:text-base">{{__("plan.contactDesc")}}</label>
                    <input id="contact" name="contact" placeholder="{{__('plan.contactDesc')}}" type="text" class="@error('contact') error @enderror w-full" value="{{ old('contact', $plan->contact) }}">
                    @error('contact')
                        <div class="text-red-700 text-xs italic pl-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2 md:mb-0">
                    <label for="owner_email" class="block mb-1 text-sm md:text-base">{{__("plan.mailDesc")}}</label>
                    <input id="owner_email" name="owner_email" placeholder="{{__('plan.mailDesc')}}" type="text" class="@error('owner_email') error @enderror w-full" value="{{ old('owner_email', $plan->owner_email) }}" @if($mode == 'edit') readonly @endif>
                    @error('owner_email')
                        <div class="text-red-700 text-xs italic pl-2">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>

            <div class="">

                <div class="block mb-2">
                    <input id="show_on_homepage" name="show_on_homepage" type="checkbox" value="1" {{ old('show_on_homepage', $plan->show_on_homepage) ? 'checked' : '' }} >
                    <label for="show_on_homepage">{{__("plan.showOnHomepage")}}</label>
                    @error('show_on_homepage')
                        <div class="text-red-700 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>

                <div class="block mb-2">
                    <input id="allow_subscribe" name="allow_subscribe" type="checkbox" value="1" {{ old('allow_subscribe', $plan->allow_subscribe) ? 'checked' : '' }} >
                    <label for="allow_subscribe">{{__("plan.allowSubscribe")}}</label>
                    @error('allow_subscribe')
                        <div class="text-red-700 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>

                <div class="block mb-2">
                    <input id="allow_unsubscribe" name="allow_unsubscribe" type="checkbox" value="1" {{ old('allow_unsubscribe', $plan->allow_unsubscribe) ? 'checked' : '' }} >
                    <label for="allow_unsubscribe">{{__("plan.allowUnsubscribe")}}</label>
                    @error('allow_unsubscribe')
                        <div class="text-red-700 text-xs italic">{{ $message }}</div>
                    @enderror
                </div>

                @if ($mode == "create")
                    <div class="block mt-4 mb-2">
                        <input id="notification" name="notification" type="checkbox" value="1" checked>
                        <label for="notification">{{__("plan.notifyMe")}}</label>
                        @error('notification')
                            <div class="text-red-700 text-xs italic">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

            </div>

            <div class="">
                <button type="submit" class="icon-button">
                    <span>{{__('general.buttonSave')}}</span>
                    @include('partials.svg.save')
                </button>

                @if($mode == "edit")
                    <a href="{{ route('plan.admin', $plan) }}" class="icon-button">
                        {{__('general.buttonCancel')}}
                        @include('partials.svg.x')
                    </a>
                @elseif($mode == "create")
                    <a href="{{ route('admin') }}" class="icon-button">
                        {{__('general.buttonCancel')}}
                        @include('partials.svg.x')
                    </a>
                @endif
            </div>
            
        </form>
        
    </div>
@endsection
