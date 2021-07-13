<div class="rounded bg-white shadow-xl p-5">
    <header>
        <div class="flex justify-between pb-8 ">
            <div>
                <h1 class="font-semibold text-4xl pb-5" style="color:#526BC5">
                    فاتورة مبيعات
                </h1>
                الديار للطاقة - دمشق
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 216 298" fill="none">
                <circle cx="193.5" cy="22.5" r="22.5" fill="#526BC5"></circle>
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M171 106V194H170.875C168.812 226.93 141.45 253 108 253C73.2061 253 45 224.794 45 190C45 155.206 73.2061 127 108 127V126.995C108.166 126.998 108.333 127 108.5 127C120.926 127 131 116.926 131 104.5C131 92.0736 120.926 82 108.5 82C108.333 82 108.166 82.0018 108 82.0054V82C48.3532 82 0 130.353 0 190C0 249.647 48.3532 298 108 298C166.308 298 213.823 251.794 215.927 194H216V190V106H215.951C215.983 105.504 216 105.004 216 104.5C216 92.0736 205.926 82 193.5 82C181.074 82 171 92.0736 171 104.5C171 105.004 171.017 105.504 171.049 106H171Z"
                    fill="#526BC5"></path>
            </svg>
        </div>
        <div class="flex justify-between pb-8">
            <div>
                <span class="text-gray-500 block">فاتورة</span>
                <select name="customer_id" id="customer_id" class="border-none">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="">
                <div class="flex flex-col">
                    <span class="text-gray-500">تاريخ اصدار الفاتورة</span>
                    <input type="date" name="issueDate" id="issueDate" class="border-none text-right text-xs">
                </div>
                <div class="flex flex-col">
                    <span class="text-gray-500">تاريخ الإستحقاق</span>
                    <input type="date" name="dueDate" id="dueDate" class="border-none text-right text-xs">
                </div>
            </div>
            <div class="">
                <div class="flex flex-col">
                    <span class="text-gray-500">رقم الفاتورة</span>
                    <input type="number" name="invoiceNumber" id="invoiceNumber"
                        class="text-right border-none text-sm ring-0" value="{{ $draftInvoice->id }}">
                </div>
            </div>
            <div class="">
                <div class="flex flex-col">
                    <span class="text-gray-500">المبلغ المستحق</span>
                    <h1 class="text-black text-xl">
                        <span>{{ $dueAmount }}</span>
                        {{ $currency->sign }}
                    </h1>
                </div>
                <div class="flex flex-col pt-4">
                    <span class="text-gray-500">سعر العملة</span>
                    <input type="number" name="currency_value" id="currnecy_value" placeholder="price" class="border-0"
                        value="{{ $USDprice }}">
                </div>
            </div>
        </div>
        <div class="rounded h-1 w-full my-5" style="background: #526BC5"></div>

    </header>
    <table class="min-w-full" cols=4>
        <thead>
            <tr>
                <th class="px-3 py-4 col-1 text-right">الوصف</th>
                <th class="px-3 py-4 col-1 text-center">السعر</th>
                <th class="px-3 py-4 col-1 text-center">الكمية</th>
                <th class="px-3 py-4 col-1 text-left">المجموع</th>
                <th class="px-3 py-4 col-1"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoiceLines as $index => $line)
                <tr>
                    <td class="w-6/12">
                        <input type="text" class=" w-full h-full border-none"
                            name="entries[{{ $index }}][description]" placeholder="أدخل وصف"
                            wire:model="invoiceLines.{{ $index }}.description" required>
                    </td>
                    <td class="">
                        <input type="number" class=" w-full h-full border-none text-center"
                            name="entries[{{ $index }}][rate]" placeholder="$0.00"
                            wire:model="invoiceLines.{{ $index }}.rate" required>
                    </td>
                    <td class="">
                        <input type="number" class=" w-full h-full border-none text-center"
                            name="entries[{{ $index }}][qty]" placeholder="0"
                            wire:model="invoiceLines.{{ $index }}.qty" required>
                    </td>
                    <td class="">
                        <input type="number" class=" w-full h-full border-none text-left"
                            name="entries[{{ $index }}][total]" placeholder="$0.00"
                            wire:model="invoiceLines.{{ $index }}.total" required>
                    </td>
                    <td wire:click.prevent="removeLine({{ $index }})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="text-gray-400 hover:text-gray-600 cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5"
                    class=" text-center px-1 py-2 rounded text-xl cursor-pointer border border-dashed border-gray-300 hover:border-gray-500 hover:text-gray-600 hover:bg-gray-50 text-gray-400"
                    wire:click.prevent="addLine">
                    + إضافة سطر جديد
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="mt-3">

        <label for="filenames">
            {{ __('attachment') }}
        </label>
        <input type="file" name="filenames" multiple/>
    </div>
</div>
