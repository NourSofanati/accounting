<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('التقارير') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-5">
                    <div class="flex justify-between px-52">
                        @include('reports.reportCard',['item'=>'Balance Sheet','name'=>'الميزانية'])
                        @include('reports.reportCard',['item'=>'General Ledger','name'=>'دفتر الإستاذ'])
                        @include('reports.reportCard',['item'=>'Profit & Loss','name'=>'الارباح والخسائر'])
                        @include('reports.reportCard',['item'=>'Trial Balance','name'=>'ميزان المراجعة'])
                        <a class=" relative p-1 border-gray-100 cursor-pointer " href="{{ route('monthly-report.create') }}">
                            <div class="h-3 w-3 bg-gray-400 rounded-full absolute mx-auto left-0 right-0 bottom-4 top-0">
                            </div>
                            <div class="bg-gray-400 rounded w-8 absolute right-0 left-0 top-1 mx-auto block h-2">
                            </div>
                            <div class="block border-8 border-gray-100 h-52 w-36 shadow hover:shadow-md transition-shadow duration-150 ">
                                <div class="w-full h-full bg-white grid place-items-center border border-gray-200 hover:border-gray-300">
                                    <img src="{{ asset('icons/reports/' . '.svg') }}" alt="" class="h-12 w-12">
                                    <hr class="border-blue-500 border-2 block w-8/12 ">
                                    <div
                                        class="block bg-gray-100 w-8/12 h-1 rounded hover:animate-pulse hover:bg-gray-200 transition-all duration-75">
                                    </div>
                                    <div
                                        class="block bg-gray-100 w-8/12 h-1 rounded hover:animate-pulse hover:bg-gray-200 transition-all duration-75">
                                    </div>
                                    <div
                                        class="block bg-gray-100 w-8/12 h-1 rounded hover:animate-pulse hover:bg-gray-200 transition-all duration-75">
                                    </div>
                                    {{ __('التقرير الشهري') }}
                                </div>
                            </div>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
