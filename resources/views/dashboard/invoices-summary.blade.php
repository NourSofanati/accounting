<div class="grid grid-cols-2 gap-5">
    <div class="bg-white border px-4 py-4 border-gray-200 h-24 w-full block text-lime-dark">
        <h1 class="text-2xl font-bold">
            {{ number_format($invoices['recievables']) . ' ' . $currency->sign }}
        </h1>
        <h2>
            المستحقة
        </h2>
    </div>
    <div class="bg-white border px-4 py-4 border-gray-200 h-24 w-full block text-lime ">
        <h1 class="text-2xl font-bold">
            {{ number_format($invoices['paid']) . ' ' . $currency->sign }}
        </h1>
        <h2>
            الأرباح
        </h2>
    </div>
    <div class="bg-white border px-4 py-4 border-gray-200 h-24 w-full block text-yellow-500 ">
        <h1 class="text-2xl font-bold">
            {{ number_format($invoices['retains']) . ' ' . $currency->sign }}
        </h1>
        <h2>
            التوقيفات
        </h2>
    </div>
    <div class="bg-white border px-4 py-4 border-gray-200 h-24 w-full block text-red-500 ">
        <h1 class="text-2xl font-bold">
            {{ number_format($invoices['paidTaxes']) . ' ' . $currency->sign }}
        </h1>
        <h2>
            الضرائب
        </h2>
    </div>

</div>
