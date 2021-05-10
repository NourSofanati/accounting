<x-app-layout >
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('لوحة التحكم') }}
        </h2>
    </x-slot>

    <div class="py-12">


        <div class=" mx-auto sm:px-6 lg:px-8">
            <div class="sm:rounded-lg">
                <div class="flex p-5">
                    <a href="{{ route('accounts.create') }}"
                        class="px-3 py-4 text-white block rounded-xl shadow-md font-bold bg-green-400 ">إنشاء حساب
                        جديد</a>
                    <a href="{{ route('journals.create') }}"
                        class="px-3 py-4 text-white block rounded-xl shadow-md font-bold bg-indigo-400 mr-4">ادخال قيود
                        جديدة</a>
                </div>
                <hr>
                <div class="p-5">
                    <table class="border min-w-full text-center table-fixed  rounded-t-xl">
                        <thead class=" border table-header-group	rounded-t-xl">
                            <tr class=" border">
                                <th class="tracking-wide w-4/12 px-4 py-3 text-right">الحساب</th>
                                <th class="tracking-wide w-4/12 px-4 py-3">نوع الحساب</th>
                                <th class="tracking-wide w-4/12 px-4 py-3">الرصيد</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountTypes as $accountType)
                                @foreach ($accountType->accounts as $item)
                                    @php
                                        $depth = 0;
                                        $items = ['item' => $item, $depth];
                                    @endphp
                                    @include('layouts.list',$items)
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
