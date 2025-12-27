@if(Session::has('fail'))
    <div class="border-1 bg-red-700 rounded md:text-lg mb-4 p-4 flex gap-2 justify-start items-center">
        <div class="w-6 md:w-8 inline-block min-w-[24px]">@include('partials.svg.cross')</div>
        <div class="font-bold">{{Session::get('fail')}}</div>
    </div>
@endif

@if(Session::has('info'))
    <div class="border-1 bg-green-700 rounded md:text-lg mb-4 p-4 flex gap-2 justify-start items-center">
        <div class="w-6 md:w-8 inline-block min-w-[24px]">@include('partials.svg.checkmark')</div>
        <div class="font-bold">{{Session::get('info')}}</div>
    </div>
@endif
