<x-app-layout>
    <x-slot name="header">
        <div class="flex place-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $account->alias }} <span class="text-gray-400">({{ $account->name }})</span>
            </h2>
            <a class="mr-5 rounded px-5 bg-lime hover:bg-lime-dark transition duration-75 py-2 text-white font-bold "
                href="{{ route('accountledger', ['account' => $account]) }}">{{ __('Ledger') }}</a>
            <a class="mr-2 rounded px-5 bg-gray-700 hover:bg-gray-800 transition duration-75 py-2 text-white font-bold "
                href="{{ route('accounts.edit', ['account' => $account]) }}">{{ __('Edit account') }}</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <table class="min-w-full text-center ">
                    <thead class="border-b">
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
                <a href="{{ route('accounts-chart') }}">الرجوع</a>
            </div>
        </div>
    </div>
</x-app-layout>
