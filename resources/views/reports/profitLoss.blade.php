<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تقرير الأرباح والخسائر') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <button class="px-3 py-2 bg-lime text-white font-bold rounded mb-3" id="printButton">طباعة</button>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div data-printable>
                    @include('reports.header',['reportName'=>'الارباح والخسائر'])
                    <div>
                        <h1 style="color:#526BC5;" class=" text-left px-4 py-3">المجموع</h1>
                        <div class="h-1 w-full rounded mt-1" style="background:#526BC5"></div>
                    </div>
                    <div class="py-3">
                        <h1 class="font-bold px-4 py-3">الدخل</h1>
                        <table class="min-w-full">
                            <tbody class="border-t border-b">
                                @php
                                    $grossIncome = 0;
                                @endphp
                                @forelse ($incomeAccounts as $item)
                                    @if ($item->dateLedgerBalance($fromData, $toData) > 0)
                                        <tr class="border-dotted border-t border-b">
                                            <td class="px-4 py-3 text-right pr-8">
                                                {{ $item->name }}
                                            </td>
                                            <td class="px-4 py-3 text-left">
                                                {{ $currency->sign . ' ' . number_format($item->dateLedgerBalance($fromData, $toData)) }}
                                                @php
                                                    $grossIncome += $item->dateLedgerBalance($fromData, $toData);
                                                @endphp
                                            </td>
                                        </tr>
                                    @endif
                                @empty

                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="font-bold">
                                    <td class="px-4 py-3 text-right">الربح الإجمالي</td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $currency->sign . ' ' . number_format($grossIncome) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="py-3 mt-14">
                        <h1 class="font-bold px-4 py-3">المصاريف</h1>
                        <table class="min-w-full">
                            <tbody class="border-t border-b">
                                @php
                                    $grossExpense = 0;
                                @endphp
                                @forelse ($expenseAccounts as $item)
                                    @if ($item->dateLedgerBalance($fromData, $toData))
                                        <tr class="border-dotted border-t border-b">
                                            <td class="px-4 py-3 text-right pr-8">
                                                {{ $item->name }}
                                            </td>
                                            <td class="px-4 py-3 text-left">
                                                {{ $currency->sign . ' ' . number_format(abs($item->dateLedgerBalance($fromData, $toData))) }}
                                                @php
                                                    $grossExpense += $item->dateLedgerBalance($fromData, $toData);
                                                @endphp
                                            </td>
                                        </tr>
                                    @endif
                                @empty

                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="font-bold">
                                    <td class="px-4 py-3 text-right">المصروف الإجمالي</td>
                                    <td class="px-4 py-3 text-left">
                                        {{ $currency->sign . ' ' . number_format(abs($grossExpense)) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mt-14 font-bold">
                        <div class="border-t-4 border-double flex justify-between">
                            <div class="px-4 py-3">الربح الصافي</div>
                            <div class="px-4 py-3">
                                {{ $currency->sign . ' ' . number_format($grossIncome + $grossExpense) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('footerScripts')
        <script>
            let printBtn = document.querySelector('#printButton');
            printBtn.onclick = () => {
                let report = document.querySelector('[data-printable]');
                let report_prime = report.cloneNode(true);
                let printableWindow = window.open('', 'mywindow', `status=1,width=${report.width},height=${report.height}`);
                printableWindow.document.write(
                    `<!DOCTYPE HTML><html dir="rtl"><head><title>Print Me</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap">${document.querySelector('#tailwindcss').outerHTML}</head>`
                );
                printableWindow.document.write('<body class="p-5" onafterprint="self.close()">');
                printableWindow.document.write(report_prime.innerHTML);
                let scrpt = printableWindow.document.createElement('script');
                scrpt.innerText = 'print();';
                printableWindow.document.write(scrpt.outerHTML);
                printableWindow.document.write('</body></html>');
            }
        </script>
    @endsection
</x-app-layout>
