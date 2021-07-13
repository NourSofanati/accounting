<div class="bg-white border border-gray-200 border-collapse">
    <header class="px-4 py-2 border-b border-gray-200 border-collapse">
        إجرائات عاجلة
    </header>
    <section class="grid grid-cols-3 border-collapse">
        <div class=" col-span-2 grid grid-cols-3 grid-rows-3 border-l border-gray-100 border-collapse">
            <a href="{{ route('vendors.create') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.vendors',['size'=>10])
                    إضافة عميل
                </span>
            </a>
            <a href="{{ route('customers.create') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.customers',['size'=>10])
                    إضافة زبون
                </span>
            </a>
            <a href="{{ route('invertories.create') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.invertories',['size'=>10])
                    إضافة مخزن
                </span>
            </a>
            <a href="{{ route('invoices.create') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.invoices',['size'=>10])
                    إنشاء فاتورة بيع
                </span>
            </a>
            <a href="{{ route('purchases.create') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.purchases',['size'=>10])
                    إضافية مشتريات
                </span>
            </a>
            <a href="{{ route('expenses.create') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.expenses',['size'=>10])
                    إدخال مصروف
                </span>
            </a>
            <a href="{{ route('taxes.index') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.taxes',['size'=>10])
                    عرض الضرائب
                </span>
            </a>
            <a href="{{ route('employees.index') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.employees',['size'=>10])
                    الموظفين
                </span>
            </a>
            <a href="{{ route('journals.create') }}"
                class="w-full h-full bg-white  py-5 border border-gray-100 text-gray-700 hover:bg-gray-700 hover:text-white border-collapse">
                <span class="grid place-items-center place-content-center">
                    @include('icons.accounts-chart',['size'=>10])
                    إنشاء قيد
                </span>
            </a>
        </div>
        <div class="py-2 text-gray-700">
            <a href="{{ route('balancesheet.index') }}" class="flex ">@include('icons.reports') تقرير الميزانية</a>
            <a href="{{ route('generalledger.index') }}" class="mt-3 flex">@include('icons.reports') دفتر الإستاذ</a>
            <a href="{{ route('profitloss.create') }}" class="mt-3 flex">@include('icons.reports') تقرير الأرباح
                والخسائر</a>
            <a href="{{ route('trialbalance.index') }}" class="mt-3 flex">@include('icons.reports') تقرير ميزان
                المراجعة</a>
            <a href="{{ route('monthly-report.create') }}" class="mt-3 flex">@include('icons.reports') التقرير
                الشهري</a>

        </div>
    </section>
</div>
