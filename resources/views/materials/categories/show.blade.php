<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('materials.index') }}">{{ __('المواد') }}</a> /
            {{ $materialCategory->name }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="flex gap-3 mb-4 ">
            <a href="{{ route('purchaseMaterial', $materialCategory) }}"
                class="px-3 py-4 text-white block rounded-xl cursor-pointer hover:scale-105 transition-all duration-100 hover:shadow-xl shadow-md font-bold bg-green-400 ">
                شراء {{ $materialCategory->name }}
            </a>
        </div>
        <div class="border-2 border-dashed p-4 ">
            <h1 class="text-2xl text-gray-700 mb-4">المواد الموجودة:</h1>
            @if ($materialCategory->materials->count() > 0)
                <div class="grid grid-cols-4 gap-5">
                    @foreach ($materialCategory->materials as $material)
                        <div class="bg-white border-2 rounded-md">
                            @php
                                $bgColor = 'bg-gray-100';
                                if ($material->all_qty == $material->remaining_qty) {
                                    $bgColor = 'bg-green-100';
                                }
                                if ($material->all_qty > $material->remaining_qty) {
                                    $bgColor = 'bg-yellow-100';
                                }

                            @endphp
                            <header class="{{ $bgColor }} p-4 text-center text-gray-600 font-bold text-xl">
                                {{ $materialCategory->name }}
                            </header>
                            <section class="px-5 grid">
                                <div class="grid grid-cols-2 border-b border-dashed py-2">
                                    <p>سعر الشراء:</p>
                                    <p>{{ $material->price }}</p>
                                </div>
                                <div class="grid grid-cols-2 border-b border-dashed py-2">
                                    <p>الكمية:</p>
                                    <p>{{ number_format($material->all_qty) . '/' . number_format($material->remaining_qty) }}
                                    </p>
                                </div>
                            </section>
                            <footer class="flex p-2 mt-3 bg-gray-50">
                                <h1 class="text-sm text-gray-600">رقم الفاتورة:
                                    {{ sprintf('%06d', $material->purchaseItem->purchase->id) }}</h1>
                            </footer>

                        </div>
                    @endforeach
                </div>
            @else
                <div
                    class="w-full flex p-5 text-center justify-center text-2xl gap-4 bg-gray-200 rounded-xl shadow-inner text-yellow-600">
                    <span class="material-icons my-auto">
                        warning
                    </span>
                    <span>
                        لا يوجد مواد
                    </span>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
