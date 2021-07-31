<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            الفاتورة رقم {{ sprintf('%06d', $invoice->id) }} <span
                class="text-gray-400 font-thin">({{ $invoice->status == 'مرسلة' && $invoice->totalDue() != $invoice->total() ? 'مدفوعة جزئيا' : $invoice->status }})</span>
            <x-print-button />
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-5">
                <div class="flex my-5">
                    @if ($invoice->status == 'مسودة')
                        <form action="{{ route('markInvoiceSent', $invoice) }}" method="post">
                            @csrf
                            <input type="submit" value="وضع علامة (تم الإرسال)" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;"
                                class="bg-green-500 text-white font-bold px-5 py-3 rounded-xl hover:bg-green-700 cursor-pointer">
                        </form>
                    @else
                        @if ($invoice->totalDue() != 0)
                            <a href="{{ route('addPayment', $invoice) }}"
                                class="bg-green-500 text-white font-bold px-5 py-3 rounded-xl hover:bg-green-700 cursor-pointer">تسجيل
                                دفعة</a>
                        @endif
                    @endif
                    <a class="text-white bg-indigo-500 font-bold px-5 py-3 rounded-xl hover:bg-indigo-300 cursor-pointer mr-5"
                        href="{{ route('generatePDF', $invoice) }}">توليد PDF</a>
                    <a class="bg-gray-200 text-gray-500 font-bold px-5 py-3 rounded-xl hover:bg-gray-300 cursor-pointer mr-5"
                        href="{{ route('invoices.index') }}">الرجوع لصفحة الفواتير</a>
                </div>

            
                <div class="rounded bg-white shadow-xl p-5" contenteditable="true" style="width: 100%;
aspect-ratio: 1/1.294;" data-printable>
                    <header>
                        <div class="flex justify-between pb-8 ">
                            <img src="https://diyarpower.com/scripts/Wells/inilogo.png" class="w-64" />
                            <div class="text-left  font-bold" dir="ltr">
                                IOI SYSTEM Tech S.A.L<br>Production Engineering ‘s<br>Middle East Company<br>
                                FAX : +963112240004<br>
                                No.{{ $invoice->id }}<br>
                                DATE : {{ $invoice->issueDate }}
                            </div>

                    </header>
                    <div class="w-10/12 mx-auto mt-10" style="font-family:'Times New Roman', Times, serif">
                        <div class="text-center" style="font-family:'Times New Roman', Times, serif">
                            السادة : {{ $invoice->customer->name }} المحترمين
                        </div>
                        <p class="font-bold">
                            إشارة إلى العقد رقم 101/2019 الموقع مع شركتكم لتحسين إنتاج خمسة وعشرين بئراً في حقل وادي
                            عبيد , وإشارة إلى
                            محضر
                            الاجتماع المشترك رقم /11/ المتضمن الكشف الشهري بكميات النفط الإضافي الزائد عن نفط الأساس
                            خلال شهر
                            {{$months[$invoice->invoice_month ]}}
                            ,
                            يرجى
                            صرف مستحقاتنا والبالغلة <span id="totalNumber" class="underline">صفر</span> دولار امريكي
                            الأساس خلال شهر
                            {{$months[$invoice->invoice_month ]}}
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
                                    <th class="border border-collapse border-black w-1/4 col-1 text-center">أجرة برميل
                                        الواحد
                                        <br />
                                        دولار اميركي
                                    </th>
                                    <th class="border border-collapse border-black w-1/4 col-1 text-center">الإجرة
                                        المستحقة
                                        <br />
                                        دولار امريكي
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->items as $index => $line)
                                    <tr>

                                        <td class="w-1/4 border border-black text-center relative">
                                            {{ $line->description }}
                                        </td>
                                        <td class="w-1/4 border border-black text-center">
                                            {{ $line->qty }}
                                        </td>
                                        <td class="w-1/4 border border-black text-center">
                                            ${{ $line->rate }}
                                        </td>
                                        <td class="w-1/4 border border-black text-center">
                                            ${{ $line->rate * $line->qty }}
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
                                        ${{ $dueAmount }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <h1 class="font-bold"> وذلك نقداً بالليرات السورية حسب المادة العاشرة من العقد وفق نشرة المصارف
                            والصرافة الصادرة
                            عن مصرف سورية
                            المركزي بتاريخ الإستحقاق</h1>

                        <h1 class="font-bold mt-10 text-center">شاكرين حسن تعاونكم
                        </h1>

                        <h1 class="font-bold mt-10 text-left">المدير العام
                        </h1>
                    </div>
                    @section('footerScripts')
                        <script>
                            totalNumber.innerText = tafqit({{ $dueAmount }});
                            // const totalNumber = document.getElementById('totalNumber');

                            // let input = document.getElementById('dueAmount');
                            // setInterval(() => {
                            // }, 50);
                        </script>
                    @endsection
                </div>
            </div>
        </div>
</x-app-layout>
