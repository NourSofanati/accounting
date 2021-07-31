<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            تسجيل دفعة للفاتورة {{ __($invoice->id) }} لجهة {{ $invoice->customer->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" max-w-4xl bg-white shadow rounded p-3 mx-auto">
            <form action="{{ route('addPayment', $invoice) }}" method="post">
                @csrf
                <div>
                    <x-jet-label for="paidAmount" value="{{ __('قيمة الدفعة') }}" />
                    <x-jet-input id="paidAmount" class="block mt-1 w-full" type="text" name="paidAmount"
                        value="{{ $invoice->totalDue() * $invoice->currency_value }}" required autofocus autocomplete="paidAmount" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="retainAmount" value="{{ __('التوقيفات') }}" />
                    <x-jet-input id="retainAmount" class="block mt-1 w-full" type="text" name="retainAmount"
                        value="0" required autofocus autocomplete="retainAmount" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="currency_value" value="{{ __('قيمة العملة') }}" />
                    <x-jet-input id="currency_value" class="block mt-1 w-full" type="text" name="currency_value"
                        value="{{ $USDprice }}" required autofocus autocomplete="currency_value" />
                </div>
                <div class="mt-4">
                    <x-jet-label for="date" value="{{ __('تاريخ الدفعة') }}" />
                    <x-jet-input id="date" class="block mt-1 w-full" type="date" name="date"
                        value="{{ now()->toDateString() }}" required autofocus autocomplete="date" />
                </div>
                {{-- @include('accounts.selectAccount') --}}
                <div class="mt-4">
                    <x-jet-label for="designatedAccountId" value="{{ __('استلام المبلغ على حساب') }}" />
                    <select name="designatedAccountId" id="designatedAccountId" required
                        class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                        @foreach ($parentAccounts as $pA)
                            @foreach ($pA->children as $child)
                                <option value="{{ $child->id }}">{{ $child->name }}</option>
                            @endforeach
                        @endforeach
                    </select>

                </div>
                <div class="mt-4">
                    @livewire('invoice-tax')
                </div>
                <div class="mt-3">

                        <label for="image">
                            {{ __('attachment') }}
                        </label>
                        <input type="file" name="image" />
                    </div>
                <div class="mt-5 flex">
                    <input type="submit" value="إضافة دفعة" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;"
                        class="rounded-md shadow-md bg-indigo-600 text-white font-bold px-3 py-3 block w-50 hover:shadow-xl transition-shadow ease-linear duration-200"></a>
                    <a href="{{ route('dashboard') }}"
                        class="rounded-md bg-gray-100 text-gray-500 font-bold px-10 py-3 block mr-5 hover:shadow-xl transition-shadow ease-linear duration-200">إلغاء</a>
                </div>
                
            </form>
        </div>
    </div>
</x-app-layout>
