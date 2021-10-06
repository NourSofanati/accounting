<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('المشتريات') }}
        </h2>
    </x-slot>

    <div class="p-6">

        <div class="flex gap-3 mb-4 ">
            <a href="{{ route('purchases.create') }}"
                class="px-3 py-4 text-white block rounded-xl cursor-pointer hover:scale-105 transition-all duration-100 hover:shadow-xl shadow-md font-bold bg-green-400">فاتورة شراء
                جديدة</a>
        </div>
        <div class="border-2 border-dashed p-4">
            <h1 class="text-2xl text-gray-700 mb-4">الأصول:</h1>
            @if ($purchases->count())
                <div class="flex flex-wrap gap-10">
                    @foreach ($purchases as $p)
                        <a href="{{ route('purchases.show', $p) }}"
                            class="bg-white border-2 hover:scale-105 hover:shadow-2xl transition-all duration-100 cursor-pointer">
                            <header class="p-2">
                                رقم الفاتورة: {{ sprintf('%06d', $p->id) }}
                            </header>
                            <section class="p-2  text-center  px-2">
                                <h2 class="font-bold text-xl pb-4 border-b text-gray-600 text-center">
                                    <span class="text-gray-500 text-lg">المورد:</span>
                                    <br>
                                    {{ $p->vendor->name }}
                                </h2>
                                <p class="text-lg text-gray-500">{{ $p->date }}</p>
                            </section>
                            <section>
                                <p class="text-green-400 text-center">
                                    {{ number_format($p->total()) . ' ل.س' }}
                                </p>
                            </section>
                            @if ($p->totalDue() == 0)
                                <section
                                    class="bg-green-200 text-green-600 text-center py-5 px-4 mt-3 text-xl font-bold">
                                    مدفوعة</section>

                            @else
                                @if ($p->totalPaid() > 0 && $p->totalPaid() < $p->total())
                                    <section
                                        class="bg-yellow-200 text-yellow-600 text-center py-5 px-4 mt-3 text-xl font-bold">
                                        مدفوعة جزئيا</section>
                                @else
                                    <section
                                        class="bg-gray-200 text-gray-600 text-center py-5 px-4 mt-3 text-xl font-bold">
                                        غير مدفوعة</section>

                                @endif
                            @endif
                        </a>
                    @endforeach
                </div>
            @else
                <div
                    class="w-full flex p-5 text-center justify-center text-2xl gap-4 bg-gray-200 rounded-xl shadow-inner text-yellow-600">
                    <span class="material-icons">
                        warning
                    </span>
                    <span>
                        لا يوجد أصول
                    </span>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
