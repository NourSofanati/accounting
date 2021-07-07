<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء زبون') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-5">
                    <form method="POST" action="{{ route('customers.store') }}">
                        @csrf
                        <div>
                            <x-jet-label for="name" value="{{ __('اسم الزبون') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                        </div>
                        <div class="mt-5 flex">
                            <input type="submit" value="إضافة الزبون"
                                class="px-3 py-2 rounded text-white block shadow-md font-bold bg-lime hover:bg-lime-dark duration-100 transition-all cursor-pointer"></a>
                            <a href="{{ route('customers.index') }}"
                                class=" bg-gray-100 text-gray-500 px-3 py-2 rounded block shadow-md font-bold  hover:bg-gray-200 mr-5 duration-100 transition-all">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
