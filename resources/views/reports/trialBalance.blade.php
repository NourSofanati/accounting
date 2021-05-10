<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('التقارير') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                @include('reports.header',['reportName'=>'ميزان المراجعة'])
                <div>
                    <h1 style="color:#526BC5;" class="">ملخص الحسابات النشطة</h1>
                    <div class="h-1 w-full rounded" style="background:#526BC5"></div>
                </div>
                <table class="min-w-full">
                    @php
                        $crTotal = 0;
                        $drTotal = 0;
                    @endphp
                    <thead>
                        <tr>
                            <th class="w-5/12 px-3 py-4 text-right">الحساب الأصلي/الحساب</th>
                            <th class="w-3/12 px-3 py-4 text-center">نوع الحساب</th>
                            <th class="w-2/12 px-3 py-4 text-center">المدين</th>
                            <th class="w-2/12 px-3 py-4 text-center">الدائن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accounts as $account)
                            @if ($account->entries->count() && $account->ledgerBalance()!= 0)
                                <tr>
                                    <td class="w-5/12 px-3 py-4 text-right"><span
                                            class=" font-thin text-gray-500">{{ $account->parent ? $account->parent->name.'/' : '' }}</span>
                                        {{ $account->name }}</td>
                                    <td class="w-3/12 px-3 py-4 text-center"> <span
                                            class="text-gray-400 ">{{ $account->accountType->name }}</span>
                                    </td>
                                    @if ($account->ledgerCredit() > $account->ledgerDebit())
                                        <td class="w-2/12 px-3 py-4 text-center">
                                            ---
                                        </td>
                                        <td class="w-2/12 px-3 py-4 text-center">
                                            ${{ abs($account->ledgerBalance()) }}
                                        </td>
                                        @php
                                            $crTotal += abs($account->ledgerBalance());
                                        @endphp
                                    @else
                                        <td class="w-2/12 px-3 py-4 text-center">
                                            ${{ abs($account->ledgerBalance()) }}
                                        </td>
                                        <td class="w-2/12 px-3 py-4 text-center">
                                            ---
                                        </td>
                                        @php
                                            $drTotal += abs($account->ledgerBalance());
                                        @endphp
                                    @endif

                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-4 border-double">
                        <tr class="text-center">
                            <td colspan="2" class=""></td>
                            <td class="px-3 py-4">${{ $drTotal }}</td>
                            <td class="px-3 py-4">${{ $crTotal }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
