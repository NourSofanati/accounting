<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('مستودع ') . $invertory->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                الأصول الموجودة:
                <table class="min-w-full mt-3">
                    <thead>
                        <tr>
                            <th>اسم الأصل</th>
                            <th>قيمة الأصل</th>
                            <th>المسؤول</th>
                            <th>المرفقات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invertory->assets as $asset)
                            <tr class="text-center">
                                <td>
                                    <a>
                                        {{ $asset->name }}
                                    </a>

                                </td>
                                <td>${{ $asset->value }}</td>
                                <td>{{ $asset->supervisor }}</td>
                                <td>
                                    @if ($asset->attachment)
                                        <a href="{{ Storage::url('public/image/' . $asset->attachment->url) }}">الملف
                                            المرفق</a>
                                    @endif
                                </td>
                            </tr>
                        @empty

                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
