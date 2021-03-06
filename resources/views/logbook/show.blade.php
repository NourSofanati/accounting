<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('التقارير') }}
            <x-print-button/>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div data-printable>
                    <div class="flex justify-between pb-8">
                        <div>
                            <h1 class="font-semibold text-4xl pb-5" style="color:#526BC5">
                                الحركة اليومية
                            </h1>
                            الديار للطاقة
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 216 298"
                            fill="none">
                            <circle cx="193.5" cy="22.5" r="22.5" fill="#526BC5"></circle>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M171 106V194H170.875C168.812 226.93 141.45 253 108 253C73.2061 253 45 224.794 45 190C45 155.206 73.2061 127 108 127V126.995C108.166 126.998 108.333 127 108.5 127C120.926 127 131 116.926 131 104.5C131 92.0736 120.926 82 108.5 82C108.333 82 108.166 82.0018 108 82.0054V82C48.3532 82 0 130.353 0 190C0 249.647 48.3532 298 108 298C166.308 298 213.823 251.794 215.927 194H216V190V106H215.951C215.983 105.504 216 105.004 216 104.5C216 92.0736 205.926 82 193.5 82C181.074 82 171 92.0736 171 104.5C171 105.004 171.017 105.504 171.049 106H171Z"
                                fill="#526BC5"></path>
                        </svg>
                    </div>
                    <div class="">
                        <div class="mb-5">
                            <div>
                                <h1>{{ $toDate ? 'الفترة الزمنية' : 'التاريخ' }}</h1>
                                <h2>{{ $fromDate }} {{ $toDate ? '->' . $toDate : '' }}</h2>
                            </div>
                        </div>
                        <hr />
                        <div>
                            <table class="min-w-full border-collapse">
                                <thead>
                                    <tr>
                                        <th class="py-3 border text-right pr-3">الحساب</th>
                                        <th class="py-3 border text-center">مدين</th>
                                        <th class="py-3 border text-center">دائن</th>
                                        <th class="py-3 border {{ $toDate ? 'text-center' : 'text-left pl-3' }}">القيد
                                        </th>
                                        @if ($toDate)

                                            <th class="py-3 border pl-3 text-left">التاريخ</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totalCr=0;
                                        $totalDr=0;
                                    @endphp
                                    @foreach ($transactions as $transaction)
                                        @foreach ($transaction->entries as $entry)
                                            <tr class="border-b hover:bg-gray-100">
                                                <td class="py-2 border pr-3">{{ $entry->account->name }}</td>
                                                <td class="py-2 border text-center">
                                                    {{ $entry->dr ? number_format($entry->dr) : '----' }}</td>
                                                <td class="py-2 border text-center">
                                                    {{ $entry->cr ? number_format($entry->cr) : '----' }}
                                                </td>
                                                <td
                                                    class="py-2 border {{ $toDate ? 'text-center' : 'text-left pl-3' }}">
                                                    <a
                                                        href="{{ route('journals.show', $transaction) }}">{{ $transaction->transaction_name }}</a>
                                                </td>
                                                @if ($toDate)
                                                    <td class="py-2 border text-left pl-3">
                                                        {{ $transaction->transaction_date }}</td>
                                                @endif
                                                @php
                                                    $totalCr+=$entry['cr'];
                                                    $totalDr+=$entry['dr'];
                                                @endphp
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="border-b hover:bg-gray-200 bg-gray-50 font-bold" >
                                        <td class="py-2 border pr-3">المجموع</td>
                                        <td class="py-2 border text-center">{{number_format($totalCr)}}</td>
                                        <td class="py-2 border text-center">{{number_format($totalDr)}}</td>
                                        <td class="py-2 border pl-3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
