<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تسجيل مكافئة للموظف: {{ $employeeDetails->fullName() }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" max-w-4xl bg-white shadow rounded p-3 mx-auto">
            <form action="{{ route('bonus.store') }}" method="post">
                @csrf
                <input type="number" name="employee_id" id="employee_id" class="sr-only"
                    value="{{ $employeeDetails->id }}">
                <div>
                    <x-jet-label for="paidAmount" value="{{ __('قيمة المكآفئة') }}" />
                    <x-jet-input id="paidAmount" class="block mt-1 w-full" type="text" name="paidAmount" value="0"
                        required autofocus autocomplete="paidAmount" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="date" value="{{ __('تاريخ منح المكآفئة') }}" />
                    <x-jet-input id="date" class="block mt-1 w-full" type="date" name="date"
                        value="{{ now()->toDateString() }}" required autofocus autocomplete="date" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="date" value="{{ __('سبب منح المكآفئة') }}" />
                    <x-jet-input id="description" class="block mt-1 w-full" type="text"
                        placeholder="ادخل سبب المكافئة هنا" name="description" required autofocus autocomplete="off" />
                </div>
                <div class="mt-4">
                    <label for="currency_value" value="Currency Value">قيمة العملة</label>
                    <x-currency-input />
                </div>
                {{-- @include('accounts.selectAccount') --}}
                <div class="mt-4">
                    <x-jet-label for="designatedAccountId" value="{{ __('دفع المبلغ من حساب') }}" />
                    <select name="designatedAccountId" id="designatedAccountId" required
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        @foreach ($parentAccounts as $pA)
                            @foreach ($pA->children as $child)
                                <option value="{{ $child->id }}">{{ $child->name }}</option>
                            @endforeach
                        @endforeach
                    </select>

                </div>
                <div class="mt-5 flex">
                    <input type="submit" value="صرف المكآفئة"
                        onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;"
                        class="rounded-md shadow-md bg-[#DF9A2C] text-white font-bold px-3 py-3 block w -50 hover:shadow-xl transition-shadow ease-linear duration-100 hover:bg-yellow-600 "></a>
                    <a href="{{ route('dashboard') }}"
                        class="rounded-md bg-gray-100 text-gray-500 font-bold px-10 py-3 block mr-5 hover:shadow-xl transition-shadow ease-linear duration-100">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
