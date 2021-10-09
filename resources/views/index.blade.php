<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div>
            <div class="sm:rounded-lg">
                <div class="flex p-5 justify-between">
                    <div class="flex">
                        <a href="{{ route('accounts.create') }}"
                            class="px-3 py-2 rounded text-white block shadow-md font-bold bg-lime ">إنشاء حساب
                            جديد</a>
                        <a href="{{ route('journals.create') }}"
                            class="px-3 py-2 rounded text-white block shadow-md font-bold bg-gray-700 mr-4">ادخال
                            قيود
                            جديدة</a>
                    </div>
                    <form class="hidden flex" action="{{ route('currency_rates.store') }}" method="post" data-isHideable>
                        @csrf
                        <x-jet-input type="number" placeholder="سعر العملة" name="currency_rate"
                            value="{{ $currency_rate ? $currency_rate->currency_rate : 1 }}" />
                        <x-jet-input type="submit" value="تعديل" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;"
                            class="px-3 bg-gray-700 shadow-md font-bold text-white mr-2" />
                    </form>
                </div>
                <div >
                    <table class="border min-w-full text-center table-fixed rounded-t-xl">
                        <thead class=" border table-header-group rounded-t-xl">
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
                                        $items = ['item' => $item, $depth, $currency_rate];
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
