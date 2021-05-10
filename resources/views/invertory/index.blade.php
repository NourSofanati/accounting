<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إدارة المستودعات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('invertories.create') }}"
                        class="bg-indigo-500 text-white font-bold px-5 py-3 rounded hover:bg-indigo-800 transition-all duration-75">إضافة
                        مخزن جديد</a>
                </div>
                <hr class="my-5">
                @forelse ($invertories as $item)
                    <div class="rounded w-full px-3 mt-5 py-4 bg-white shadow-md">
                        <h1 class="block mb-3">
                            {{ $item->name }}
                        </h1>
                        @if ($item->children->count())
                            <div
                                class="bg-gray-100 rounded px-5 py-5 w-full grid grid-cols-{{ $item->children->count() < 3 ? $item->children->count() : 3 }} gap-5">
                                @foreach ($item->children as $child)
                                    <div class="bg-white h-10 flex w-full text-center rounded  relative">
                                        <a href="{{ route('invertories.show', $child) }}"
                                            class="h-full w-full grid place-items-center">{{ $child->name }}</a>
                                        
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    لا يوجد مستدوعات بقاعدة البيانات
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
