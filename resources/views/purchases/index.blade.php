<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('المشتريات') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('purchases.create') }}"
                        class="px-3 py-4 text-white block rounded-xl shadow-md font-bold bg-green-400 ">شراء أصول جديدة</a>
                    {{-- <a href="{{ route('journals.create') }}"
                        class="px-3 py-4 text-white block rounded-xl shadow-md font-bold bg-indigo-400 mr-4">ادخال قيود
                        جديدة</a> --}}
                </div>
                <hr class=" my-4">
                @if (false)
                    {{-- <table class="min-w-full text-center">
                        <thead>
                            <tr class=" border-dotted border-b">
                                <th class="px-3 py-4">الاسم</th>
                                <th class="px-3 py-4">رقم الهاتف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr>
                                    <td class="px-3 py-4">{{ $vendor->name }}</td>
                                    <td class="px-3 py-4">{{ $vendor->phone }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                @else
                    لا يوجد مشتريات حاليا.
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
