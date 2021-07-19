<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء فاتورة جديدة') }}
        </h2>
    </x-slot>
    <form class="hidden flex" action="{{ route('currency_rates.store') }}" method="post" data-isHideable>
                        @csrf
                        <x-jet-input type="number" placeholder="سعر العملة" name="currency_rate"
                            value="{{ $currency_rate ? $currency_rate->currency_rate : 1 }}" />
                        <x-jet-input type="submit" value="تعديل"
                            class="px-3 bg-gray-700 shadow-md font-bold text-white mr-2" />
                    </form>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5 bg-white rounded-xl shadow-xl">
                <div class="" style="width: 100%;
                aspect-ratio: 1/1.294;" contenteditable="true">
                    <table class="table-auto border-collapse border w-6/12 p-5 mx-auto text-xl">
                        <tbody>
                            <tr class="border">
                                <td class="border px-5 py-2">الدخل</td>
                                <td class="border px-5 py-2"></td>
                                <td class="border px-5 py-2 text-green-600 font-bold">{{ $totalIncome }}</td>
                            </tr>
                            <tr class="border">
                                <td class="border px-5 py-2">الضرائب</td>
                                <td class="border px-5 py-2 font-bold text-red-600">{{ $taxes }}</td>
                                <td class="border px-5 py-2"></td>
                            </tr>
                            <tr class="border">
                                <td class="border px-5 py-2">التوقيفات</td>
                                <td class="border px-5 py-2 font-bold text-red-600">{{ $retains }}</td>
                                <td class="border px-5 py-2"></td>
                            </tr>
                            <tr class="border">
                                <td class="border px-5 py-2">الدخل الصافي</td>
                                <td class="border px-5 py-2"></td>
                                <td class="border px-5 py-2 text-green-600 font-bold">{{ $totalPaid }}</td>
                            </tr>
                            <tr class="border">
                                <td class="border px-5 py-2">النفقات</td>
                                <td class="border px-5 py-2 font-bold text-red-600">{{ (abs($expenses) - abs($taxes)) }}</td>
                                <td class="border px-5 py-2"></td>
                            </tr>
                            <tr class="border">
                                <td class="border px-5 py-2">الربح الصافي</td>
                                <td class="border px-5 py-2"></td>
                                <td class="border px-5 py-2 text-green-600 font-bold">{{ ($totalPaid - (abs($expenses) - abs($taxes))) }}</td>
                            </tr>
                            @foreach ($equityAccounts as $acc)
                                <tr class="border">
                                    <td class="border px-5 py-2">حصة السيد {{ $acc->name }}</td>
                                    <td class="border px-5 py-2 font-bold">
                                        @if ($totalEquity != 0)
                                            {{ ($acc->balance() / $totalEquity) * abs($totalPaid - (abs($expenses) - abs($taxes))) }}

                                    </td>
                                    <td class="border px-5 py-2"></td>
                            @endif
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
