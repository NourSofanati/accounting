<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('مستودع ') . $invertory->name }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div>
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('createFromInvertory', $invertory) }}"
                        class="bg-indigo-500 text-white font-bold px-5 py-3 rounded-xl shadow hover:bg-indigo-800 transition-all duration-75">إضافة
                        أصول </a>
                    <a href="{{ route('purchaseFromInvertory', $invertory) }}"
                        class="bg-green-500 text-white font-bold px-5 py-3 rounded-xl shadow hover:bg-green-800 transition-all duration-75 mr-5 ">شراء
                        أصول جديدة</a>
                </div>
                <hr class="my-5">

                المستودعات
                @forelse ($invertory->children as $item)
                    <div class="rounded w-full px-3 mt-5 py-4 bg-white shadow-md">
                        <a class="block mb-3" href="{{ route('invertories.show', $item) }}">
                            {{ $item->name }}
                        </a>
                        @if ($item->children->count())
                            <a
                                class="bg-gray-100 rounded px-5 py-5 w-full grid grid-cols-{{ $item->children->count() < 3 ? $item->children->count() : 3 }} gap-5">
                                @foreach ($item->children as $child)
                                    <div class="bg-white h-10 flex w-full text-center rounded  relative">
                                        <a href="{{ route('invertories.show', $child) }}"
                                            class="h-full w-full grid place-items-center">{{ $child->name }}</a>

                                    </div>
                                @endforeach
                            </a>
                        @endif
                    </div>
                @empty
                    <span class="text-gray-500">لا يوجد مخازن داخل هذا المستودع</span>
                @endforelse
                <hr class="my-5">
                <div class="border-2 border-dashed p-4">
                    <h1 class="text-2xl border-b-2 border-dashed pb-2 text-gray-600">
                        الأصول
                    </h1>
                    <section class="mt-2 flex flex-wrap gap-10">
                        @forelse ($invertory->assets as $asset)
                            <div data-id="{{ $asset->id }}" data-isShowAssetModal
                                class="border-2 text-center bg-white w-[250px] py-2 hover:scale-105 duration-100 transition cursor-pointer hover:shadow-2xl">
                                <h1 class="text-xl py-2 pb-2 border-b-2 border-dashed">
                                    {{ $asset->name }}
                                </h1>
                                <p class="text-center text-lg text-green-500 font-bold pb-2 border-b-2 border-dashed">
                                    {{ $asset->value }} ل.س
                                </p>
                                <p class="text-center text-lg">
                                    المورد: {{ $asset->vendor->name }}
                                </p>
                                <p class="text-center text-lg">
                                    رقم الفاتورة: {{ $asset->purchaseItem->purchase->id }}
                                </p>
                            </div>
                            @include('utils.assetModal')
                        @empty
                            <div class="w-full text-center text-xl">
                                لا يوجد اصول
                            </div>
                        @endforelse

                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
