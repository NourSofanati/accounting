<table class="w-full border-1 border-gray-300" cols=2>
    <thead>
        <tr class="">
            <th class="px-3 py-4  text-center">
                نوع الضريبة
            </th>
            <th class="px-3 py-4  text-center">
                قيمة الضريبة
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($taxItems as $index=>$item)
            <tr class="">
                <td>
                    {{-- <input type="text" class=" w-full h-full border-none"
                        name="taxItems[{{ $index }}][tax_id]" placeholder="أدخل وصف"
                        wire:model="taxItems.{{ $index }}.tax_id" required> --}}
                    <select name="taxItems[{{ $index }}][tax_id]" id="taxItems[{{ $index }}][tax_id]"
                        class="border-0 py-4 w-full h-full" required>
                        @foreach ($taxCategories as $tax)
                            <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="text" class=" w-full h-full border-none py-4  text-center"
                        name="taxItems[{{ $index }}][tax_amount]" placeholder="قيمة الضريبة"
                        wire:model="taxItems.{{ $index }}.tax_amount" required>
                </td>
            </tr>
        @empty

        @endforelse
    </tbody>
    <thead>
        <tr>
            <td colspan="2"
                class=" text-center px-1 py-2 rounded text-xl cursor-pointer border border-dashed border-gray-300 hover:border-gray-500 hover:text-gray-600 hover:bg-gray-50 text-gray-400"
                wire:click.prevent="addNewTax">
                + إضافة ضريبة جديدة

            </td>
        </tr>
    </thead>
</table>