<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تسجيل اجازة للموظف: {{ $employeeDetails->fullName() }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" max-w-4xl bg-white shadow rounded p-3 mx-auto">
            <form action="{{ route('vacations.store') }}" method="post">
                @csrf

                <input type="number" name="employee_id" id="employee_id" class="sr-only"
                    value="{{ $employeeDetails->id }}">
                <div class="grid grid-cols-2 gap-5">
                    <div>
                        <x-jet-label for="fromDate" value="{{ __('من :') }}" />
                        <x-jet-input id="fromDate" class="block w-full" type="datetime-local" name="fromDate"
                            value="{{ $employeeDetails->totalDue() }}" required autofocus />
                    </div>
                    <div class="">
                        <x-jet-label for="toDate" value="{{ __('الى:') }}" />
                        <x-jet-input id="toDate" class="block w-full" type="datetime-local" name="toDate"
                            value="{{ now()->toDateString() }}" required autofocus />
                    </div>
                </div>
                <div class="mt-4 grid w-1/2">
                    <label for="description">الوصف / السبب</label>
                    <input type="text" name="description" id="description"
                        class="border-gray-300 focus:border-indigo-300 focus:ring w-full focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </div>
                <div class="mt-4 grid w-1/2">
                    <label for="paid" class="my-auto">نوع الأجازة</label>
                    <select id="paid" oninput="hide(event)"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        name="paid">
                        <option value="false">اجازة غير مدفوعة</option>
                        <option value="true"> اجازة مدفوعة</option>
                    </select>
                </div>
                <div class="mt-4 grid w-1/2" data-hide data-temp1>
                    <label for="currency_value">قيمة العملة</label>
                    <x-currency-input />
                </div>

                <div class="mt-5 grid w-1/2" data-hide data-temp2>
                    <label for="amount">قيمة الخصم</label>
                    <input id="amount" name="amount"
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        type="number" min=0>
                </div>
                <div class="mt-5 flex">
                    <input type="submit" value="تسجيل الأجازة"
                        onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;"
                        class="rounded-md shadow-md bg-indigo-500 text-white font-bold px-3 py-3 block w -50 hover:shadow-xl transition-shadow ease-linear duration-100 hover:bg-indigo-700 "></a>
                    <a href="{{ route('dashboard') }}"
                        class="rounded-md bg-gray-100 text-gray-500 font-bold px-10 py-3 block mr-5 hover:shadow-xl transition-shadow ease-linear duration-100">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
    @section('footerScripts')
        <script>
            const hide = (e) => {
                if (e.target.value == "false") {
                    document.querySelectorAll('[data-hide]').forEach(x => x.classList.remove('hidden'));
                } else {
                    document.querySelectorAll('[data-hide]').forEach(x => x.classList.add('hidden'));
                }
            }
        </script>
    @endsection
</x-app-layout>
