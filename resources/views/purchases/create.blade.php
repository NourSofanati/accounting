<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('شراء أصول') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-lg rounded">
            <form action="{{ route('fixedAssets.store') }}" method="post">
                @csrf
                <div class="p-5">
                    <div class="mt-3">
                        <label for="name">
                            اسم الأصل
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required>
                    </div>
                    <div class="mt-3">
                        <label for="value">
                            قيمة الأصل
                        </label>
                        <input type="number" name="value" id="value"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required>
                    </div>
                    <div class="mt-3">
                        <label for="currency_value">
                            قيمة العملة
                        </label>
                        <x-currency-input />
                    </div>
                    <div class="mt-3">
                        <label for="purchase_date">
                            تاريخ شراء الأصل
                        </label>
                        <input type="date" name="purchase_date" id="purchase_date"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required>
                    </div>
                    <div class="mt-3">
                        <label for="supervisor">
                            اسم المسؤول
                        </label>
                        <input type="text" name="supervisor" id="supervisor"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required>
                    </div>

                    <div class="mt-3">
                        <label for="purchase_account">
                            من حساب
                        </label>
                        <select class="w-full border-1 border-gray-300 rounded mt-2" name="purchase_account"
                            id="purchase_account">
                            @foreach ($equityAccounts as $pA)
                                @foreach ($pA->children as $child)
                                    <option value="{{ $child->id }}">{{ $child->name }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3">
                        <label for="invertory_id">
                            المستودع
                        </label>
                        <select name="invertory_id" id="invertory_id"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2">
                            @forelse ($invertories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @empty

                            @endforelse
                        </select>
                    </div>
                    <div class="mt-3">
                        <x-jet-label for="attachment" />
                        المرفق
                        </x-jet-label>
                        <x-jet-input type="text" name="attachment" />
                    </div>
                    <div class="mt-3">
                        <input type="submit" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;" value="إضافة الأصل"
                            class="block py-3 px-4 bg-indigo-600 text-white rounded cursor-pointer">
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
