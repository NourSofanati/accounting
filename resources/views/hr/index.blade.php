<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الموظفين') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    @if ($hasPositions)
                        <a href="{{ route('employees.create') }}"
                            class="bg-indigo-500 text-white font-bold px-5 py-3 rounded hover:bg-indigo-800 transition-all duration-75">إضافة
                            موظف جديد</a>
                    @endif
                    <a href="{{ route('positions.create') }}"
                        class="bg-green-500 mr-5 text-white font-bold px-5 py-3 rounded hover:bg-green-800 transition-all duration-75">إضافة
                        منصب جديد</a>
                </div>
                <hr class="my-5">

                @forelse ($employees as $item)
                    <a class="flex bg-gray-100 shadow-lg my-10 p-1 rounded-full"
                        href="{{ route('employees.show', $item) }}">

                        @if ($item->picture)
                            <img src="{{ Storage::url('public/images/' . $item->picture->uri) }}" alt=""
                                class="rounded-full border-4 border-gray-300" width="126" height="126">
                        @else
                            <img src="{{ asset('images/employee.png') }}" alt=""
                                class="rounded-full border-4 border-gray-300" width="126" height="126">
                        @endif
                        <div class="flex flex-col mr-5 pt-3">
                            <h1 class="font-semibold text-2xl ">{{ $item->fullName() }}</h1>
                            <h2 class="text-xl text-gray-600">
                                {{ $item->invertory->name }} /
                                {{ $item->position->name }}
                            </h2>
                            <p class="font-thin text-lg text-gray-500">
                                {{ \Carbon\Carbon::parse($item->birthDate)->diff(\Carbon\Carbon::now())->format('%y سنة') }}
                            </p>

                        </div>
                    </a>
                @empty
                    لا يوجد موظفين حاليا
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
