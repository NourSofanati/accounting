<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('شراء مواد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('purchases.store') }}" method="post" id="materialsForm">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-lg rounded py-6">
                @csrf
                @include('purchases.header',['recieptName'=>'شراء '.$materialCategory->name])
                <div class="
                grid grid-cols-2 gap-5 mt-5">
                    <div class="mt-3">
                        <label for="vendor_id" class="text-lg">
                            {{ __('Vendor') }}</label>
                        <div class="flex">
                            <select name="vendor_id" class="bg-gray-50 border-gray-300 border rounded w-full"
                                id="vendors" required>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                @endforeach
                            </select>
                            <button id="addVendor"><span class="material-icons my-auto">add</span></button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="invertory_id" class="text-lg">
                            {{ __('Invertory') }}</label>
                        <div class="flex">
                            <select name="invertory_id" class="bg-gray-50 border-gray-300 border rounded w-full"
                                id="invertories" required>
                                @foreach ($invertories as $invertory)
                                    <option value="{{ $invertory->id }}">{{ $invertory->name_and_path() }}</option>
                                @endforeach
                            </select>
                            <button id="addInvertory"><span class="material-icons my-auto">add</span></button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="date" class="text-lg">
                            {{ __('Purchase date') }}</label>
                        <div class="flex">
                            <input type="date" name="date" id="date"
                                class="bg-gray-50 border-gray-300 border rounded w-full" required>
                        </div>
                    </div>
                    <input type="hidden" name="type" value="material">
                    <div class="mt-3">
                        <label for="notes" class="text-lg">
                            {{ __('Notes') }}</label>
                        <textarea name="notes" id="notes" cols="30" rows="3"
                            class="bg-gray-50 border-gray-300 border rounded w-full"></textarea>
                    </div>
                    <div class="mt-3">
                        <label for="type" class="text-lg">
                            {{ __('سعر العملة') }}</label>
                        <div class="flex">
                            <x-currency-input />

                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto py-6 grid grid-cols-3 gap-10" id="cards">

                <div class="bg-white rounded shadow-lg px-8 py-6" data-index="1">
                    <div class="grid grid-cols-3">
                        {{-- <label for="item[1][item_name]" class="my-auto">اسم العنصر:</label> --}}
                        <input type="hidden" name="item[1][item_name]"
                            class="border-gray-300 w-full rounded col-span-2" value="{{ $materialCategory->name }}">
                        <input type="hidden" name="category_id" value="{{ $materialCategory->id }}">
                    </div>
                    <div class="grid grid-cols-3 mt-4 relative">
                        <label for="item[1][price]" class="my-auto">السعر الافرادي:</label>
                        <input type="text" name="item[1][price]" id="item_price"
                            class="border-gray-300 w-full rounded col-span-2" required>
                        <div
                            class="border-gray-200 border-r text-gray-500 absolute h-full left-0 w-[85px] top-0 bottom-0 flex">
                            <div class="my-auto mx-auto">ل.س</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 mt-4 relative">
                        <label for="item[1][qty]" class="my-auto">العدد/الكمية:</label>
                        <input type="text" name="item[1][qty]" id="item_qty"
                            class="border-gray-300 w-full rounded col-span-2" required>
                        <div
                            class="border-gray-200 border-r text-gray-500 absolute h-full left-0 w-[85px] top-0 bottom-0 flex">
                            <div class="my-auto mx-auto">{{ $materialCategory->unit }}</div>
                        </div>
                    </div>
                    <hr class="mt-4">
                    <div class="grid grid-cols-3 mt-4 relative">
                        <label class="my-auto">السعر الكلي:</label>
                        <input type="number" id="totalPrice"
                            class="border-gray-300 w-full rounded col-span-2 bg-gray-100" disabled>
                        <div
                            class="border-gray-200 border-r text-gray-500 absolute h-full left-0 w-[85px] top-0 bottom-0 flex">
                            <div class="my-auto mx-auto">ل.س</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 max-w-7xl mx-auto">
                <input type="submit" value="حفظ" class="block py-3 px-4 bg-indigo-600 text-white rounded cursor-pointer"
                    onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;">
            </div>
        </form>
    </div>
    @include('utils.createVendorModal')
    @include('utils.createInvertoryModal')
    @push('custom-scripts')
        <script>
            $('#item_price').on('input', function(e) {
                $('#totalPrice').val($('#item_price').val() * $('#item_qty').val())
            });
            $('#item_qty').on('input', function(e) {
                $('#totalPrice').val($('#item_price').val() * $('#item_qty').val())
            });
        </script>
    @endpush
</x-app-layout>
