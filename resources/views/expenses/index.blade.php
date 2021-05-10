<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('المصاريف') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('expenses.create') }}"
                        class="bg-indigo-500 text-white font-bold px-5 py-3 rounded hover:bg-indigo-800 transition-all duration-75">إنشاء
                        فاتورة جديدة</a>
                </div>
                <hr class="my-5">
                <div class="gap-1.5 grid grid-cols-6 max-w-full">
                    @foreach ($expenses as $expense)
                        @if ($expense->vendor)
                            <div class="rounded">
                                <a href="{{ route('expenses.show', $expense) }}"
                                    class="rounded border-2 border-gray-200 h-60 w-44 block">
                                    <div class="rounded  border-4 border-gray-300 h-full w-full relative">
                                        <div class="flex flex-col justify-between h-full pb-16">
                                            <div class="p-2 text-gray-500">
                                                <span class="block mb-3">{{ sprintf('%06d', $expense->id) }}</span>
                                                <span class="block font-bold">{{ $expense->vendor->name }}</span>
                                                <span class="block">{{ $expense->issueDate }}</span>
                                            </div>
                                            <div class="text-center px-2">
                                                <hr>
                                                <span class=" text-lg">${{ $expense->total() }}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="absolute bottom-0 grid place-items-center text-center left-0 right-0 mx-auto w-full h-14 bg-gray-100 text-gray-500 font-bold text-xl">
                                            <span>
                                                @switch($expense->totalDue())
                                                    @case($expense->total())
                                                        غير مدفوعة
                                                        @break
                                                    @case(0)
                                                        مدفوعة
                                                        @break
                                                    @default
                                                        مدفوعة جزئيا
                                                @endswitch
                                            </span>
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
