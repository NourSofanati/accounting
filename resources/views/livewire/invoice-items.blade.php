<div class="rounded bg-white shadow-xl p-5" style="width: 100%;
aspect-ratio: 1/1.294;">
    <header>
        <div class="flex justify-between pb-8 ">
            <img src="https://diyarpower.com/scripts/Wells/inilogo.png" class="w-64" />
            <div class="text-left  font-bold" dir="ltr">
                {{-- <h1 class="font-semibold text-4xl pb-5" style="color:#526BC5">
                    فاتورة مبيعات
                </h1>
                الديار للطاقة - دمشق --}}

                IOI SYSTEM Tech S.A.L<br>Production Engineering ‘s<br>Middle East Company<br>
                FAX : +963112240004<br>
                No.<input type="number" name="invoiceNumber" id="invoiceNumber"
                    class="border-none text-sm ring-0 bg-transparent focus:outline-none active:outline-none focus:border-none active:border-none"
                    value="{{ $draftInvoice->id }}"><br>
                DATE : <input type="date" name="issueDate" id="issueDate"
                    class="border-none text-xs bg-transparent focus:outline-none active:outline-none focus:border-none active:border-none">
                <br>
            </div>
            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 216 298" fill="none">
                <circle cx="193.5" cy="22.5" r="22.5" fill="#526BC5"></circle>
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M171 106V194H170.875C168.812 226.93 141.45 253 108 253C73.2061 253 45 224.794 45 190C45 155.206 73.2061 127 108 127V126.995C108.166 126.998 108.333 127 108.5 127C120.926 127 131 116.926 131 104.5C131 92.0736 120.926 82 108.5 82C108.333 82 108.166 82.0018 108 82.0054V82C48.3532 82 0 130.353 0 190C0 249.647 48.3532 298 108 298C166.308 298 213.823 251.794 215.927 194H216V190V106H215.951C215.983 105.504 216 105.004 216 104.5C216 92.0736 205.926 82 193.5 82C181.074 82 171 92.0736 171 104.5C171 105.004 171.017 105.504 171.049 106H171Z"
                    fill="#526BC5"></path>
            </svg> --}}
        </div>
        {{-- <div class="flex justify-between pb-8">
             <div>
                <span class="text-gray-500 block">فاتورة</span>
                <select name="customer_id" id="customer_id" class="border-none">
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div> --}}
        {{-- <div class="">
                {{-- <div class="flex flex-col">
                    <span class="text-gray-500">تاريخ اصدار الفاتورة</span>
                    
                </div> --}}
        {{-- <div class="flex flex-col">
                    <span class="text-gray-500">تاريخ الإستحقاق</span>
                    <input type="date" name="dueDate" id="dueDate" class="border-none text-right text-xs">
                </div> 
            </div> --}}
        {{-- <div class="">
                <div class="flex flex-col">
                    <span class="text-gray-500">رقم الفاتورة</span>

                </div>
            </div> --}}
        {{-- <div class="">
                <div class="flex flex-col">
                    <span class="text-gray-500">المبلغ المستحق</span>
                    <h1 class="text-black text-xl">
                        <span>{{ $dueAmount }}</span>
                        {{ $currency->sign }}
                    </h1>
                </div>
                
            </div> 
        </div> --}}
        {{-- <div class="rounded h-1 w-full my-5" style="background: #526BC5"></div> --}}

    </header>
    <div class="flex flex-col pt-4">
        <span class="text-gray-500">سعر مصرف سورية المركزي</span>
        <input type="number" name="currency_value" id="currnecy_value" placeholder="price" class="border-0"
            value="{{ 2512 }}">
    </div>
    <div class="w-10/12 mx-auto mt-10" style="font-family:'Times New Roman', Times, serif">
        <div class="text-center" style="font-family:'Times New Roman', Times, serif">
            السادة : <select name="customer_id" id="customer_id" class="border-none appearance-none"
                style="	appearance: none;">
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </select> المحترمين
        </div>
        <p class="font-bold">
            إشارة إلى العقد رقم 101/2019 الموقع مع شركتكم لتحسين إنتاج خمسة وعشرين بئراً في حقل وادي عبيد , وإشارة إلى
            محضر
            الاجتماع المشترك رقم /11/ المتضمن الكشف الشهري بكميات النفط الإضافي الزائد عن نفط الأساس خلال شهر
            <select class="appearance-none border-none py-0" wire:model="selectedMonth" name="invoice_month"
                id="invoice_month" required>
                @foreach ($months as $index => $month)
                    <option value="{{ $index }}">{{ $month }}</option>
                @endforeach
            </select>
            ,
            يرجى
            صرف مستحقاتنا والبالغلة <span id="totalNumber" class="underline">صفر</span> دولار امريكي الأساس خلال شهر
            <input type="text" disabled class="p-0 border-none appearance-none w-20"
                value="{{ sprintf('%02d', $selectedMonth + 1) . '/' . '2021' }}" required name="invoice_date" id="invoice_date">
            وفق مايلي:
        </p>
        <table class="min-w-full border border-collapse border-black table-fixed text-center mt-10">
            <thead>
                <tr>
                    <th class="border border-collapse border-black w-1/4 col-1 text-center">الشهر</th>
                    <th class="border border-collapse border-black w-1/4 col-1 text-center">كمية النفط
                        الزائدة
                        <br />
                        برميل
                    </th>
                    <th class="border border-collapse border-black w-1/4 col-1 text-center">أجرة برميل الواحد
                        <br />
                        دولار اميركي
                    </th>
                    <th class="border border-collapse border-black w-1/4 col-1 text-center">الإجرة المستحقة
                        <br />
                        دولار امريكي
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoiceLines as $index => $line)
                    <tr>

                        <td class="w-1/4 border border-black text-center relative">
                            <input type="text" class=" w-full h-full border-none"
                                name="entries[{{ $index }}][description]" placeholder="أدخل وصف"
                                wire:model="invoiceLines.{{ $index }}.description" required>
                            <a wire:click.prevent="removeLine({{ $index }})" class="absolute -right-7 top-2">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    class="text-gray-400 hover:text-gray-600 cursor-pointer w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </td>
                        <td class="w-1/4 border border-black text-center">
                            <input type="number" class=" w-full h-full border-none text-center"
                                name="entries[{{ $index }}][rate]" placeholder="$0.00"
                                wire:model="invoiceLines.{{ $index }}.rate" required>
                        </td>
                        <td class="w-1/4 border border-black text-center">
                            <input type="number" class=" w-full h-full border-none text-center"
                                name="entries[{{ $index }}][qty]" placeholder="0"
                                wire:model="invoiceLines.{{ $index }}.qty" required>
                        </td>
                        <td class="w-1/4 border border-black text-center">
                            <input type="number" class=" w-full h-full border-none text-center"
                                name="entries[{{ $index }}][total]" placeholder="$0.00"
                                wire:model="invoiceLines.{{ $index }}.total" required>
                        </td>

                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td class="border border-black py-2">المجموع</td>
                    <td class="border border-black py-2"></td>
                    <td class="border border-black py-2"></td>
                    <td class="border border-black py-2">
                        <input type="number" class=" w-full h-full border-none text-center" value="{{ $dueAmount }}"
                            disabled id="dueAmount" />
                    </td>
                </tr>
                <tr>
                    <td colspan="4"
                        class=" text-center px-1 py-2 rounded text-xl cursor-pointer border border-dashed border-gray-300 hover:border-gray-500 hover:text-gray-600 hover:bg-gray-50 text-gray-400"
                        wire:click.prevent="addLine">
                        + إضافة سطر جديد
                    </td>
                </tr>
            </tfoot>
        </table>
        <h1 class="font-bold"> وذلك نقداً بالليرات السورية حسب المادة العاشرة من العقد وفق نشرة المصارف والصرافة الصادرة
            عن مصرف سورية
            المركزي بتاريخ الإستحقاق</h1>

        <h1 class="font-bold mt-10 text-center">شاكرين حسن تعاونكم
        </h1>

        <h1 class="font-bold mt-10 text-left">المدير العام
        </h1>
        <div class="mt-3">

            <label for="filenames">
                {{ __('attachment') }}
            </label>
            <input type="file" name="filenames" multiple />
        </div>
    </div>

    @section('footerScripts')
        <script>
            const totalNumber = document.getElementById('totalNumber');

            let input = document.getElementById('dueAmount');
            setInterval(() => {
                totalNumber.innerText = tafqit(input.value);
            }, 50);
        </script>
    @endsection

</div>
