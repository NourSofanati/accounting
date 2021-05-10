<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            الفاتورة رقم {{ sprintf('%06d', $reciept->id) }} <span class="text-gray-400 font-thin"></span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-5">
                <div class="flex my-5">
                    @if ($reciept->totalDue() != 0)
                        <a href=" {{ route('addExpense', $reciept) }} "
                            class="bg-green-500 text-white font-bold px-5 py-3 rounded-xl hover:bg-green-700 cursor-pointer">تسجيل
                            دفعة</a>
                    @endif
                    <a class="bg-gray-200 text-gray-500 font-bold px-5 py-3 rounded-xl hover:bg-gray-300 cursor-pointer mr-5"
                        href="{{ route('expenses.index') }}">الرجوع لصفحة الفواتير</a>
                </div>

                <div class="rounded bg-white shadow-xl p-5">
                    <header>
                        <div class="flex justify-between pb-8 ">
                            <div>
                                <h1 class="font-semibold text-4xl pb-5" style="color:#526BC5">
                                    فاتورة مصاريف
                                </h1>
                                الديار للطاقة - دمشق
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 216 298"
                                fill="none">
                                <circle cx="193.5" cy="22.5" r="22.5" fill="#526BC5"></circle>
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M171 106V194H170.875C168.812 226.93 141.45 253 108 253C73.2061 253 45 224.794 45 190C45 155.206 73.2061 127 108 127V126.995C108.166 126.998 108.333 127 108.5 127C120.926 127 131 116.926 131 104.5C131 92.0736 120.926 82 108.5 82C108.333 82 108.166 82.0018 108 82.0054V82C48.3532 82 0 130.353 0 190C0 249.647 48.3532 298 108 298C166.308 298 213.823 251.794 215.927 194H216V190V106H215.951C215.983 105.504 216 105.004 216 104.5C216 92.0736 205.926 82 193.5 82C181.074 82 171 92.0736 171 104.5C171 105.004 171.017 105.504 171.049 106H171Z"
                                    fill="#526BC5"></path>
                            </svg>
                        </div>
                        <div class="flex justify-between pb-8">
                            <div>
                                <span class="text-gray-500 block">فاتورة</span>
                                {{-- <p>{{ $reciept->vendor->name }}</p> --}}
                            </div>
                            <div class="">
                                <div class="flex flex-col">
                                    <span class="text-gray-500">تاريخ اصدار الفاتورة</span>
                                    <input type="date" name="issueDate" id="issueDate"
                                        class="border-none text-right text-xs" value="{{ $reciept->issueDate }}"
                                        disabled>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-gray-500">تاريخ الإستحقاق</span>
                                    <input type="date" name="dueDate" id="dueDate"
                                        class="border-none text-right text-xs" value="{{ $reciept->dueDate }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="">
                                <div class="flex flex-col">
                                    <span class="text-gray-500">رقم الفاتورة</span>
                                    <input type="number" name="recieptNumber" id="recieptNumber"
                                        class="text-right border-none text-sm ring-0" value="{{ $reciept->id }}">
                                </div>
                            </div>
                            <div class="">
                                <div class="flex flex-col">
                                    <span class="text-gray-500">المبلغ المستحق</span>
                                    <h1 class="text-black text-xl">$ <span>{{ $reciept->totalDue() }}</span>
                                    </h1>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reciept->items as $index => $line)
                                <tr>
                                    <td class="w-6/12">
                                        <input type="text" class=" w-full h-full border-none"
                                            name="entries[{{ $index }}][description]" placeholder="أدخل وصف"
                                            value="{{ $line->description }}" disabled>
                                    </td>
                                    <td class="">
                                        <input type="number" class=" w-full h-full border-none text-center"
                                            name="entries[{{ $index }}][rate]" placeholder="$0.00"
                                            value="{{ $line->rate }}" disabled>
                                    </td>
                                    <td class="">
                                        <input type="number" class=" w-full h-full border-none text-center"
                                            name="entries[{{ $index }}][qty]" placeholder="0"
                                            value="{{ $line->qty }}" disabled>
                                    </td>
                                    <td class="">
                                        <input type="number" class=" w-full h-full border-none text-left"
                                            name="entries[{{ $index }}][total]" placeholder="$0.00"
                                            value="{{ $line->qty * $line->rate }}" disabled>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
