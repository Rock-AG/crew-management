@extends('layout.app', ['includeHeader' => false])

@section('body')
<header class="bg-ci-orange-light text-center w-full mb-4 md:mb-6 text-ci-black text-shadow-black-on-orange">
    <div class="header-bg-image p-4 md:py-6 xl:py-8 max-w-7xl mx-auto">
        <h1>
            <span class="text-3xl md:text-5xl xl:text-7xl font-tower-ruins ">{{ __('home.titleTop') }}</span><br />
            <span class="text-xl md:text-3xl xl:text-5xl font-sans [font-variant:small-caps]">{{ __('home.titleSub') }}</span>
        </h1>
        <p class="mt-2 text-sm md:text-base xl:text-lg">
            {!! __('home.titleCopy') !!}
        </p>
    </div>
</header>
<section class="homepage-content flex-1 text-center px-4 py-4 md:py-6 md:mx-auto md:w-3xl">
    <h2 class="section-header mb-4 text-center">{{__('home.contentHeader')  }}</h2>
    @if ($plans->count() == 0)
        <p class="italic md:text-lg m-8">{!! __('home.noPlans') !!}</p>
    @endif
    @foreach ($plans as $plan)
        <a href="{{ route('plan.show', ['plan' => $plan]) }}" class="icon-button icon-arrow mx-auto my-2 w-full max-w-md md:max-w-xl xl:max-w-2xl md:p-4">
            <span class="text-base md:text-xl">{{ $plan->title }}</span><br />
            <span class="text-xs md:text-base font-light italic">{{ $plan->getTimespan() }}</span>
            @if (str_contains($plan->title, "Burg"))<span class="burg"></span>@endif
        </a>
    @endforeach
</section>
@endsection
