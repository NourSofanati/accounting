<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('vendors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('vendors.create') }}"
                        class="px-3 py-2 rounded text-white block shadow-md font-bold bg-lime hover:bg-lime-dark duration-100 transition-all cursor-pointer">إضافة
                        مورد
                        جديد</a>
                </div>
                <hr class=" my-4">
                @forelse ($vendors as $vendor)
                    <a class="flex bg-white shadow rounded-xl w-full mb-5" href="{{ route('vendors.show', $vendor) }}">
                        <div class="p-5">
                            <img src="https://lh3.googleusercontent.com/proxy/QFYt4j4cgj_-WOjq0Lmba1liUARCUVK74O86vwvK-2hNpzqSDJpjULGzq9pJ0K_lk0MHss8v9piM38m5cYqpGSejqSIvLy-kK9yORzxP6iE"
                                class="h-20 rounded-full w-20 my-auto ring-4" />
                        </div>
                        <div class="p-5 text-right">
                            <h1 class="font-bold text-xl text-gray-700">
                                {{ $vendor->name }}
                            </h1>
                            <h2 class="text-gray-600 font-semibold" dir="ltr">
                                {{ $vendor->phone }}
                            </h2>
                            <p class="text-gray-600">
                                {{ $vendor->address }}
                            </p>
                        </div>
                    </a>
                @empty
                    لا يوجد مورّدون حاليا.
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
