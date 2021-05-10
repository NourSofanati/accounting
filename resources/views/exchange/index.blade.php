<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تحويل عملة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('exchange.create') }}"
                        class="bg-indigo-500 text-white font-bold px-5 py-3 rounded hover:bg-indigo-800 transition-all duration-75">تحويل
                        مبلغ جديد</a>
                </div>
                <hr class="my-5">
                
                <h1 class="text-2xl text-gray-600 mb-5">
                    التحويلات السابقة
                </h1>
                <div class="gap-1.5 grid grid-cols-6 max-w-full">
                    <div class="rounded">
                        <a href="{{ route('invoices.create') }}"
                            class="rounded border-2 bg-gray-100 border-gray-200 h-60 w-44 block">
                            <div
                                class="grid h-full border-4 rounded border-gray-300 border-dashed w-full place-items-center text-gray-400">
                                <div class="text-center">
                                    <span class="block font-bold text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto " fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </span>
                                    <span>تحويل
                                        مبلغ جديد</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
