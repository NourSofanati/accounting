<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $account->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <table class="min-w-full text-center ">
                    <thead class="border-b ">
                        <tr class="h-16">
                            <th class="text-right">اسم القيد</th>
                            <th>تاريخ القيد</th>
                            <th>وصف القيد</th>
                            <th>قيمة العملة</th>
                            <th class="text-left">المبلغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('transactions.row',$account)
                    </tbody>
                </table>
            </div>
            <div class="mt-5">
                <a href="{{ route('dashboard') }}">الرجوع</a>
            </div>
        </div>
    </div>
</x-app-layout>
