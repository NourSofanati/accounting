

<!DOCTYPE HTML>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
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
            padding: 10px;
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
</head>

<body contenteditable="true">
    <div style="    display: flex;
    flex-direction: row-reverse;
    justify-content: space-between;">
        <p style="text-align:left;font-family:Calibri ">
            IOI SYSTEM Tech S.A.L<br>Production Engineering ‘s<br>Middle East Company<br>
            FAX : +963112240004<br>
            No.{{ $invoice->id }}<br>
            DATE : {{ $invoice->issueDate ?? $invoice->created_at->toDateString() }}<br>
        </p>
        <img width=250 src="https://diyarpower.com/scripts/Wells/inilogo.png" />
    </div>
    <br>
    <div class="container">
        <h3 style="text-align:center;"> السادة : الشركة السورية للنفط المحترمين</h3>
        <h4 style="text-align:left;text-decoration:underline;">الموضوع : طلب صرف فاتورة </h4>
        <p>
            إشارة إلى العقد رقم 101/2019 الموقع مع شركتكم لتحسين إنتاج خمسة وعشرين بئراً في حقل وادي عبيد , وإشارة إلى
            محضر الاجتماع المشترك رقم /11/ المتضمن الكشف الشهري بكميات النفط الإضافي الزائد عن نفط الأساس خلال شهر
            {{ 'haha' }}
            , يرجى صرف مستحقاتنا والبالغلة
            {{ $invoice->total() }}$
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
                @php
                    $totalQty = 0;
                    $totalRecievable = 0;
                @endphp
                @foreach ($invoice->items as $index => $line)
                    <tr>
                        <td>
                            {{ $line->description }}
                        </td>
                        <td>
                            {{ $line->qty }}
                        </td>
                        <td>
                            ${{ $line->rate }}
                        </td>
                        <td>
                            ${{ $line->qty * $line->rate }}
                        </td>
                    </tr>
                    @php
                        $totalQty += $line->qty;
                        $rate = $line->rate;
                        $totalRecievable += $line->qty * $line->rate;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>المجموع</td>
                    <td>{{ $totalQty }}</td>
                    <td>${{ $rate }}</td>
                    <td>${{ $totalRecievable }}</td>
                </tr>
            </tfoot>
        </table>
        <p>
            وذلك نقداً بالليرات السورية حسب المادة العاشرة من العقد وفق نشرة المصارف والصرافة الصادرة عن مصرف سورية
            المركزي بتاريخ الإستحقاق
        </p>
        <br>
        <br>
        <center>
            <p>شاكرين حسن تعاونكم </p>
        </center>
        <br>

        <br>

        <p style="text-align:left;">
            المدير العام
        </p>
    </div>
</body>

</html>
