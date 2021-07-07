<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الزبائن') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{route('customers.create')}}" class="px-3 py-2 rounded text-white block shadow-md font-bold bg-lime hover:bg-lime-dark duration-100 transition-all">إضافة زبون جديد</a>
                </div>
                <hr class="my-5">
                @foreach ($customers as $item)
                    <div class="w-full py-4 shadow-md text-center bg-white rounded-xl px-3 ">
                        {{$item->name}}
                    </div>
                @endforeach                
            </div>
        </div>
    </div>
</x-app-layout>
