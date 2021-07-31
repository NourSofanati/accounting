<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('التقارير') }}
        </h2>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                @include('reports.header',['reportName'=>'دفتر الإستاذ العام'])
                @foreach ($types as $type)
                    @foreach ($type->ledgerAccounts as $account)
                        @if ($account->entries->count())
                            <div class=" my-24">
                                <h1 style="color:#526BC5;" class="font-bold">حساب {{ $account->name }}</h1>
                                <p class="text-sm text-gray-400 pb-2">{{ $type->name }}</p>
                                <div class="h-1 w-full rounded" style="background:#526BC5"></div>
                                <table class="min-w-full text-center mb-10 mt-4">
                                    <thead class="border-b ">
                                        <tr>
                                            <th class="py-4 w-3/12 text-right">المرجع</th>
                                            <th class="py-4 w-3/12 ">التاريخ والملاحظات</th>
                                            <th class="py-4 w-3/12 ">مدين</th>
                                            <th class="py-4 w-3/12 ">دائن</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-b border-double ">
                                        @foreach ($account->entries as $entry)
                                            <tr class="text-gray-500 border-dotted border-b border-t">
                                                <td class="py-4 text-right whitespace-nowrap">
                                                    {{ $entry->transaction->transaction_name }}</td>
                                                <td class="py-4 ">{{ $entry->transaction->transaction_date }}</td>
                                                <td class="py-4 ">
                                                    {{ $entry['dr'] ? $currency->sign . ' ' . $entry['dr'] : '' }}
                                                </td>
                                                <td class="py-4 ">
                                                    {{ $entry['cr'] ? $currency->sign . ' ' . $entry['cr'] : '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="border-double border-t-4">
                                        <tr class="font-semibold">
                                            <td class="py-4 text-right">الرصيد المرحّل</td>
                                            <td class="sr-only">خرا ما حدا حيشوفو</td>
                                            @if ($account->ledgerCredit() > $account->ledgerDebit())
                                                <td class=""></td>
                                                <td class="py-4 ">
                                                    {{ $currency->sign . ' ' . ($account->ledgerCredit() - $account->ledgerDebit()) }}
                                                </td>
                                            @else
                                                <td class="py-4 ">
                                                    {{ $currency->sign . ' ' . ($account->ledgerDebit() - $account->ledgerCredit()) }}
                                                </td>
                                                <td class=""></td>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
