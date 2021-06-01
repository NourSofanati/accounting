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
                        <a href="{{ route('exchange.create') }}"
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
                    @foreach ($exchanges as $item)
                        <div class="rounded">
                            <a href="{{ route('invoices.show', $item) }}"
                                class="rounded border-2  h-60 w-44 block {{ $item->amount > $item->amount_spent ? 'bg-green-100 border-green-200' : 'bg-red-100 border-red-200' }}">
                                <div
                                    class="grid h-full border-4 rounded border-gray-300 border w-full place-items-center {{ $item->amount > $item->amount_spent ? 'text-green-400' : 'text-red-400' }}">
                                    <div class="text-center">
                                        <span class="block font-bold text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path
                                                    d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <span>{{ $item->date }}</span><br />
                                        <span>قيمة التحويل {{ $item->amount }}</span><br />
                                        <span>المصروف {{ $item->amount_spent }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    @endforeach
                </div>
            </div>
        </div>
</x-app-layout>
