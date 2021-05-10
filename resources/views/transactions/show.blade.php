<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $transaction->transaction_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="min-w-full border ">
                    @php
                        $totalDr = 0;
                        $totalCr = 0;
                    @endphp
                    <thead class="bg-gray-50 tracking-wide">
                        <tr>
                            <th class="px-3 py-4 text-right">الحساب</th>
                            <th class="px-3 py-4 text-center">المدين</th>
                            <th class="px-3 py-4 text-center">الدائن</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaction->entries as $entry)
                            <tr class="hover:bg-indigo-50 ">
                                <td class="px-3 border-t border-b py-4 text-right">{{ $entry->account->name }}
                                </td>
                                <td class="px-3 border-t border-b py-4 text-center">{{ $entry->dr }}</td>
                                <td class="px-3 border-t border-b py-4 text-center">{{ $entry->cr }}</td>
                            </tr>
                            @php
                                $totalDr += $entry->dr;
                                $totalCr += $entry->cr;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td class="px-3 py-4 text-center sr-only text-green-500">{{ $totalDr - $totalCr }}
                            </td>
                            <td class="px-3 py-4 text-center text-green-500 font-bold">{{ $totalDr }}</td>
                            <td class="px-3 py-4 text-center text-green-500 font-bold">{{ $totalCr }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="mt-5">
                <a href="{{ route('accounts.show',$account) }}">الرجوع</a>
            </div>
        </div>
    </div>
</x-app-layout>
