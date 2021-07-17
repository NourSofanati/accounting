<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء فاتورة جديدة') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5 bg-white">
                <div class="" style="width: 100%;
                aspect-ratio: 1/1.294;">
                    <style>
                        table,
                        th,
                        td,
                        tr {
                            border-collapse: collapse;
                            border: solid 1px;
                        }

                        td,
                        th {
                            text-align: center;
                            font-weight: bold;
                        }

                        table {
                            margin: auto;
                            width: 100%;
                        }

                        p,
                        tfoot {
                            font-weight: bold;
                        }

                        .container {
                            padding-top: 50px;
                            width: 80%;
                            margin: auto;
                        }

                    </style>
                    <div style="    display: flex;
flex-direction: row-reverse;
justify-content: space-between; ">

                        <p style="text-align:left;font-family:Calibri ">
                            IOI SYSTEM Tech S.A.L<br>Production Engineering ‘s<br>Middle East Company<br>
                            FAX : +963112240004<br>
                            No. 1 <br>
                            DATE : aa<br>
                        </p>
                        <img width=250 src="https://diyarpower.com/scripts/Wells/inilogo.png" />
                    </div>
                    <br>
                    <div class="container" style="font-family:'Times New Roman', Times, serif">
                        <h3 style="text-align:center;"> السادة : الشركة السورية للنفط المحترمين</h3>
                        <h4 style="text-align:left;text-decoration:underline;">الموضوع : طلب صرف فاتورة </h4>
                        <p>
                            إشارة إلى العقد رقم 101/2019 الموقع مع شركتكم لتحسين إنتاج خمسة وعشرين بئراً في حقل وادي
                            عبيد ,
                            وإشارة
                            إلى
                            محضر الاجتماع المشترك رقم /11/ المتضمن الكشف الشهري بكميات النفط الإضافي الزائد عن نفط
                            الأساس
                            خلال
                            شهر
                            {{ 'haha' }}
                            , يرجى صرف مستحقاتنا والبالغلة
                            <span id="totalNumber" class="underline">صفر</span>
                            دولار امريكي
                            الأساس خلال شهر
                            {{ 'month' }} {{ 'year' }}
                            وفق مايلي:
                        </p>

                        <br>
                        <br>
                        <table>
                            <thead>
                                <tr>
                                    <th>الشهر</th>
                                    <th>كمية النفط الزائدة <br> برميل</th>
                                    <th>أجرة برميل الواحد<br>دولار اميركي</th>
                                    <th>الإجرة المستحقة<br>دولار امريكي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-0"><input type="text" id="rowMonth"
                                            class="w-full h-full border-none focus:outline-none focus:border-none active:border-none active:outline-none text-center" />
                                    </td>
                                    <td class="p-0"><input type="number" value="0" id="rowBarrels"
                                            class="w-full h-full border-none focus:outline-none focus:border-none active:border-none active:outline-none text-center" />
                                    </td>
                                    <td class="p-0"><input type="number" value="0" id="rowPerBarrel"
                                            class="w-full h-full border-none focus:outline-none focus:border-none active:border-none active:outline-none text-center" />
                                    </td>
                                    <td class="p-0"><input type="text" id="rowTotalFuel" disabled value="$0"
                                            class="w-full h-full border-none focus:outline-none focus:border-none active:border-none active:outline-none text-center" />
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>المجموع</td>
                                    <td class="p-0"><input type="number" id="totalFuel" disabled
                                            class="w-full h-full border-none focus:outline-none focus:border-none active:border-none active:outline-none" />
                                    </td>
                                    <td>$<span id="costPerBarrel"></span></td>
                                    <td>$<span id="totalPrice"></span></td>
                                </tr>
                            </tfoot>
                        </table>
                        <p>
                            وذلك نقداً بالليرات السورية حسب المادة العاشرة من العقد وفق نشرة المصارف والصرافة الصادرة عن
                            مصرف
                            سورية
                            المركزي بتاريخ الإستحقاق
                        </p>
                        <br>
                        <br>

                        <p style="text-align:center;">شاكرين حسن تعاونكم </p>

                        <br>

                        <br>

                        <p style="text-align:left;">
                            المدير العام
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('footerScripts')
        <script>
            const input = document.getElementById('total');
            const totalNumber = document.getElementById('totalNumber');
            const rowBarrels = document.getElementById('rowBarrels');
            const rowPerBarrel = document.getElementById('rowPerBarrel');
            const rowTotalFuel = document.getElementById('rowTotalFuel');
            rowBarrels.onkeyup = () => handleChange();
            rowPerBarrel.onkeyup = () => handleChange();

            function handleChange() {
                let rowMoney = (rowBarrels.value * rowPerBarrel.value);
                rowTotalFuel.value = "$" + rowMoney;
                totalNumber.innerText = tafqit(rowMoney);
            }
        </script>
    @endsection
</x-app-layout>
