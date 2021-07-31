<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            التوقيفات
        </h2>
    </x-slot>
    <div class="py-12">
        <div class=" max-w-4xl bg-white shadow rounded p-3 mx-auto">
            <form action="{{ route('claimRetainsStore') }}" method="post">
                @csrf
                <span class="text-gray-500 mb-4">
                    قبض التوقيفات التالية:
                </span>
                @forelse ($retains as $retain)
                    <div class="w-full p-3 mt-3 shadow rounded-xl flex justify-between bg-gray-50">
                        <span>الفاتورة {{ sprintf('%07d', $retain->invoice->id) }}</span>
                        <span>
                            ${{ $retain->amount }}
                        </span>
                    </div>
                @empty
                    لا يوجد تويقفات
                @endforelse
                <div class="mt-5">
                    <div class="mt-4">
                        <x-jet-label for="date" value="{{ __('تاريخ الدفعة') }}" />
                        <x-jet-input id="date" class="block mt-1 w-full" type="date" name="date"
                            value="{{ now()->toDateString() }}" required autofocus autocomplete="date" />
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="currency_value" value="{{ __('قيمة العملة') }}" />
                        <x-jet-input id="currency_value" class="block mt-1 w-full" type="text" name="currency_value"
                            value="{{ $USDprice }}" required autofocus autocomplete="currency_value" />
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="designatedAccountId" value="{{ __('قبض التوقيفات على حساب') }}" />
                        <select name="designatedAccountId" id="designatedAccountId" required
                            class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                            @foreach ($parentAccounts as $pA)
                                @foreach ($pA->children as $child)
                                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr class="my-5">
                @csrf
                <input type="submit" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;" value="قبض التوقيفات" class="p-4 bg-indigo-500 text-white rounded">
            </form>
        </div>
    </div>
</x-app-layout>
