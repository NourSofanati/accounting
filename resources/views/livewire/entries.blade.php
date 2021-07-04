<form method="POST" action="{{ route('journals.store') }}">
    <input type="number" value="{{ $newTransaction->id }}" class="sr-only" name="transaction_id">
    @csrf

    <div class="w-full">
        <div class="grid grid-cols-2 gap-5">
            <div class="mb-5 col-span-1">
                <x-jet-label for="name" value="{{ __('اسم القيد') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
            </div>
            <div class="mb-5 col-span-1">
                <x-jet-label for="date" value="{{ __('تاريخ القيد') }}" />
                <x-jet-input id="date" class="block mt-1 w-full" type="date" name="date" :value="old('date')" required
                    autofocus autocomplete="date" />
            </div>
        </div>
        <div class="mb-5">
            <x-jet-label for="وصف القيد" value="{{ __('وصف القيد') }}" />
            <textarea name="description" id="description" cols="30" rows="2 "
                class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
        </div>
    </div>
    <hr class="my-5">
    <div class="mt-4">
        <table class="text-right w-full">
            <thead>
                <tr class="text-gray-500 tracking-wide font-light">
                    <th class="px-3">اسم الحساب</th>
                    <th class="px-3">مدين</th>
                    <th class="px-3">دائن</th>
                    @if ($currency->code == 'SYP')
                        <th class="px-3">قيمة العملة</th>
                    @endif
                    @if (count($entries) > 2)
                        <th class="px-3"></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($entries as $index => $entry)

                    <tr>
                        <td class="px-1">
                            <select name="entries[{{ $index }}][account_id]"
                                id="entries[{{ $index }}][account_id]" required
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block  w-full"
                                wire:model.lazy="entries.{{ $index }}.account_id">
                                @foreach ($accountTypes as $item)
                                    <optgroup label="◀{{ $item->name }}">
                                        @if ($item->accounts->count() > 0)
                                            @foreach ($item->accounts as $item)
                                                @php
                                                    $isTransaction = true;
                                                @endphp
                                                @include('accounts.listAccounts',['isTransaction'=>$isTransaction])

                                            @endforeach
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>
                        </td>
                        <td class="px-1">
                            <x-jet-input id="entries[{{ $index }}][dr]" name="entries[{{ $index }}][dr]"
                                type="number" placeholder="أدخل قيمة المدين"
                                wire:model.lazy="entries.{{ $index }}.dr"
                                disabled="{{ $entries[$index]['cr'] != 0 }}"
                                class="{{ $entries[$index]['cr'] != 0 ? ' bg-gray-100 text-gray-300 border-gray-200' : '' }}  w-full"
                                min=0 data-inputType="debit" />
                        </td>
                        <td class="px-1">
                            <x-jet-input id="entries[{{ $index }}][cr]" name="entries[{{ $index }}][cr]"
                                type="number" placeholder="أدخل قيمة الدائن"
                                wire:model.lazy="entries.{{ $index }}.cr"
                                disabled="{{ $entries[$index]['dr'] != 0 }}"
                                class="{{ $entries[$index]['dr'] != 0 ? ' bg-gray-100 text-gray-300 border-gray-200' : '' }}  w-full"
                                min=0 data-inputType="credit" />
                        </td>
                        @if ($currency->code == 'SYP')
                            <td class="px-1">
                                <x-jet-input id="entries[{{ $index }}][currency_value]"
                                    name="entries[{{ $index }}][currency_value]" type="number"
                                    placeholder="أدخل قيمة الدائن"
                                    wire:model.lazy="entries.{{ $index }}.currency_value" min=0 />
                            </td>
                        @endif
                        @if (count($entries) > 2)
                            <td>
                                <a wire:click.prevent="removeEntry({{ $index }})" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        class="text-gray-400 hover:text-gray-600 transition-colors duration-150"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                <tr>
                    <td class="
                        @if ($diff !=0) text-red-500 @endif ">الفرق: {{ $diff }}</td>
                    <td>المدين الكلي: <x-jet-input value="{{ $totalDr }}" name="totalDr"/>
                        <br>
                        <span class=" text-gray-500">(${{ number_format($totalDrUSD, 2) }})</span>
                    </td>
                    <td>الدائن الكلي: <x-jet-input value="{{ $totalCr }}" name="totalCr"/>
                        <br>
                        <span class="text-gray-500">(${{ number_format($totalCrUSD, 2) }})</span>
                    </td>
                </tr>
                <tr>
                    <td colspan=" 4">
                        <button class=" border border-dashed border-gray-400 text-sm w-full py-3 mt-3 rounded-xl"
                            wire:click.prevent="addEntry">إضافة سطر جديد</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="mt-5 flex">
        <input type="submit" value="إضافة القيد"
            class="rounded-md shadow-md font-bold px-3 py-3 block w-50 hover:shadow-xl transition-shadow ease-linear duration-200 {{ $diff != 0 ? ' cursor-not-allowed bg-gray-400 text-gray-600' : 'bg-indigo-600 cursor-pointer text-white' }}"
            {{ $diff != 0 ? 'disabled' : '' }}></a>
        <a wire:click.prevent="cancelTransaction"
            class="rounded-md bg-gray-100 text-gray-500 font-bold px-10 py-3 block mr-5 hover:shadow-xl transition-shadow ease-linear duration-200">إلغاء</a>
    </div>
</form>


