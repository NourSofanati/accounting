<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الضرائب') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('taxes.create') }}"
                        class="bg-red-500 text-white font-bold px-5 py-3 rounded hover:bg-indigo-800 transition-all duration-75">إنشاء
                        نوع ضرائب جديد</a>
                </div>
                <hr class="my-5">
                @forelse ($taxes as $item)
                    <a href="{{ route('taxes.show', $item) }}" class="bg-gray-50 flex justify-between">
                        {{ $item->name }}
                    </a>
                @empty
                    لا يوجد ضرائب
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
