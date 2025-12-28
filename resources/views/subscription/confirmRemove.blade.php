@extends('layout.app', [
    'includeHeader' => true,
    'pageTitle' => 'Absage bestätigen (' . $shift->title . ')',
])

@section('body')
    <div class="max-w-full mx-2 mb-4 flex-1">
        {{-- Header + Intro-Text --}}
        <div class="w-full mb-6 md:mb-12 md:max-w-1/2 md:mx-auto text-center">
            <h1 class="section-header mb-2">{{ __('subscription.removeConfirm.title') }}</h1>
            <p class="text-sm md:text-base mb-2">{{ __('subscription.removeConfirm.intro') }}</p>
        </div>

        <div class="mb-6 md:mb-12">
            <p class="text-lg md:text-2xl text-center mb-2 md:mb-4">{{ $plan->title }}</p>
            <p class="text-lg md:text-2xl text-center font-bold">{{ $shift->title }}</p>
            <p class="md:text-lg text-center mb-2 md:mb-4">{!! \App\Http\Controllers\PlanController::buildDateString($shift->start, $shift->end, true) !!}</p>
        </div>

        <div class="w-full mb-6 md:mb-12 md:max-w-1/2 md:mx-auto text-center">
            <form method="post" action="{{route('subscription.remove.doConfirm', [$plan, $shift, $unsubscribeConfirmationKey])}}">
                @csrf

                <button type="submit" class="icon-button big-button" title="{{__('subscription.buttonUnsubscribeConfirm')}}">
                    <span>{{__('subscription.buttonUnsubscribeConfirm')}}</span>
                    @include('partials.svg.frown')
                </button>
            </form>
        </div>
    </div>
@endsection
