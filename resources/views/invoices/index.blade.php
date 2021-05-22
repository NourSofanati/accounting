<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('المبيعات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('invoices.create') }}"
                        class="bg-indigo-500 text-white font-bold px-5 py-3 rounded hover:bg-indigo-800 transition-all duration-75">إنشاء
                        فاتورة جديدة</a>
                    <a href="{{ route('claimRetains') }}"
                        class="bg-yellow-500 mr-4 text-white font-bold px-5 py-3 rounded hover:bg-yellow-800 transition-all duration-75">
                        التوقيفات</a>
                </div>
                <hr class="my-5">

                <div class="grid mb-14 gap-1 grid-cols-5 max-w-full place-items-center text-center">
                    @forelse ($revenue as $key=> $item)
                        <div class="">
                            <h1 class="text-4xl text-indigo-500">
                                {{ $currency->sign. ' '.number_format($item) }}
                            </h1>
                            <span class="text-xl text-gray-500">{{ __($key) }}</span>
                        </div>
                    @empty

                    @endforelse
                </div>
                <hr class="my-5 mt-16">
                <h1 class="text-2xl text-gray-600 mb-5">
                    الفواتير
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
                                    <span>إنشاء فاتورة جديدة</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @foreach ($invoices as $invoice)
                        @if ($invoice->customer)
                            <div class="rounded">
                                <a href="{{ route('invoices.show', $invoice) }}"
                                    class="rounded border-2 border-gray-200 h-60 w-44 block">
                                    <div class="rounded  border-4 border-gray-300 h-full w-full relative">
                                        <div class="flex flex-col justify-between h-full pb-16">
                                            <div class="p-2 text-gray-500">
                                                <span class="block mb-3">{{ sprintf('%06d', $invoice->id) }}</span>
                                                <span class="block font-bold">{{ $invoice->customer->name }}</span>
                                                <span class="block">{{ $invoice->issueDate }}</span>
                                            </div>
                                            <div class="text-center px-2">
                                                <hr>
                                                <span class=" text-lg">${{ $invoice->total() }}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="absolute bottom-0 grid place-items-center text-center left-0 right-0 mx-auto w-full h-14 bg-{{ $colors[$invoice->status] }}-100 text-{{ $colors[$invoice->status] }}-500 font-bold text-xl">
                                            <span>{{ $invoice->status == 'مرسلة' && $invoice->totalDue() != $invoice->total() ? 'مدفوعة جزئيا' : $invoice->status }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
