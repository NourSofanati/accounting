<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء ضريبة جديدة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-5">
                    <form method="POST" action="{{ route('taxes.store') }}">
                        @csrf
                        <div>
                            <x-jet-label for="name" value="{{ __('اسم الضريبة') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                        </div>
                        <div class="mt-5 flex">
                            <input type="submit" value="إضافة الضريبة"
                                class="rounded-md shadow-md bg-indigo-600 text-white font-bold px-3 py-3 block w-50 hover:shadow-xl transition-shadow ease-linear duration-200"></a>
                            <a href="{{ route('taxes.index') }}"
                                class="rounded-md bg-gray-100 text-gray-500 font-bold px-10 py-3 block mr-5 hover:shadow-xl transition-shadow ease-linear duration-200">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
