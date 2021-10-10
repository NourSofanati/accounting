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
            <a href="{{ route('spendMaterial', $materialCategory) }}"
                class="px-3 py-4 text-white block rounded-xl cursor-pointer hover:scale-105 transition-all duration-100 hover:shadow-xl shadow-md font-bold bg-red-400 ">
                انفاق {{ $materialCategory->name }}
            </a>
        </div>
        <div class="border-2 border-dashed p-4 ">
            <h1 class="text-2xl text-gray-700 mb-4">المواد الموجودة:</h1>
            @if ($materialCategory->materials->count() > 0)
                @include('materials.categories.materials-list')
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
