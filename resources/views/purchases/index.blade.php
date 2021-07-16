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
                        class="px-3 py-4 text-white block rounded-xl shadow-md font-bold bg-green-400 ">شراء أصول
                        جديدة</a>
                    {{-- <a href="{{ route('journals.create') }}"
                        class="px-3 py-4 text-white block rounded-xl shadow-md font-bold bg-indigo-400 mr-4">ادخال قيود
                        جديدة</a> --}}
                </div>
                <hr class=" my-4">
                @if ($purchases->count())

                    <table class="min-w-full text-center">
                        <thead>
                            <tr class=" border-dotted border-b">
                                <th class="px-3 py-4">الاسم</th>
                                <th class="px-3 py-4">المستودع</th>
                                <th class="px-3 py-4">القيمة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalValue = 0;
                            @endphp
                            @foreach ($purchases as $p)
                                <tr>
                                    <td class="px-3 py-4">
                                        {{
                                            $p->name
                                        }}
                                    </td>
                                    <td class="px-3 py-4">
                                        <a href="{{ route('invertories.show', $p->invertory) }}">
                                            {{ $p->invertory->name }}
                                        </a>
                                    </td>
                                    <td class="px-3 py-4">{{ $p->value . ' ' . $currency->sign }}</td>
                                </tr>
                                @php
                                    $totalValue += $p->value;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-4 border-double font-bold">
                                <td class="px-3 py-4">المجموع:</td>
                                <td class="px-3 py-4">
                                </td>
                                <td class="px-3 py-4">{{ $totalValue . ' ' . $currency->sign }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    لا يوجد مشتريات حاليا.
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
