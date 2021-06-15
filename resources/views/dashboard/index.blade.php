

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard') }}
        </h2>
    </x-slot>
    <div class="w-full p-12">
        <div class="grid grid-cols-2 gap-6 ">
            <div class="bg-white border border-gray-200">
                <header class="px-4 py-2 border-b border-gray-200">
                    إجمالي الفواتير
                </header>
                <section>
                    <img src="{{asset('images/graph1.png')}}"/>
                </section>
            </div>
            @include('dashboard.quick-actions')
            @include('dashboard.invoices-summary')
            <div class="bg-white border border-gray-200">
                <header class="px-4 py-2 border-b border-gray-200">
                    إجمالي الفواتير
                </header>
                <section class="p-3">
                    <div id="expenses-chart"></div>
                </section>
            </div>
        </div>
    </div>

</x-app-layout>
@section('footerScripts')
@endsection