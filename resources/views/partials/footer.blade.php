<footer class="page-footer mt-4 md:mt-10 lg:mt-20">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row">
        <div class="w-full p-4 text-center md:text-left flex flex-1 flex-col md:flex-row">
            <span class="md:mr-4"><a href="{{ route('imprint') }}" class="textlink" title="{{ __('navigation.imprint') }}">{{ __('navigation.imprint') }}</a></span>
            <span class="md:ml-4"><a href="{{ route('admin') }}" class="textlink" title="{{ __('navigation.admin') }}">{{ __('navigation.admin') }}</a></span>
        </div>
        <div class="w-full p-4 text-center border-t-1 border-ci-gray-light md:border-0 flex flex-col flex-2 md:flex-row md:justify-end">
            <span class="italic md:mr-4">{{ __('navigation.copyleft') }}</span>
            <span class="md:mx-4"><a class="textlink" href="https://github.com/Rock-AG/crew-management" rel="external" title="{{ __('navigation.source') }}">{{ __('navigation.source') }}</a></span>
            <span class="md:ml-4"><a class="textlink" href="https://www.gnu.org/licenses/agpl-3.0.en.html" rel="external" title="{{ __('navigation.license') }}">{{ __('navigation.license') }}</a></span>
        </div>
    </div>
</footer>