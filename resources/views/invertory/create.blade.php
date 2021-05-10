<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء مستودع جديد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-lg rounded">
            <form action="{{ route('invertories.store') }}" method="post">
                @csrf
                <div class="p-5">
                    <div class="mt-3">
                        <label for="name">
                            اسم المستودع
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required>
                    </div>
                    <div class="mt-3">
                        <label for="parent_id">
                            داخل المستودع
                        </label>
                        <select name="parent_id" id="parent_id"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2">
                            <option value="">لا يوجد مستودع حاوي</option>
                            @forelse ($invertories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <div class="mt-3">
                        <input type="submit" value="إضافة المستودع" class="block py-3 px-4 bg-indigo-600 text-white rounded cursor-pointer">
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
