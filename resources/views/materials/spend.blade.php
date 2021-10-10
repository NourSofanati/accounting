<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('انفاق مواد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('material-spendings.store') }}" method="post" id="materialsForm">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white shadow-lg rounded py-6">
                @csrf
                @include('purchases.header',['recieptName'=>'انفاق '.$materialCategory->name])
                <div class="
                grid gap-5 mt-5">
                    <div>
                        <input type="hidden" name="material_id" value="{{ $materialCategory->id }}" />
                        <label for="material" class="text-lg">
                            {{ __('المادة') }}</label>
                        <div class="flex">
                            <input type="text" name="material" id="material"
                                class="bg-gray-100 text-gray-600 border-gray-300 border rounded w-full py-2 px-2"
                                value="{{ $materialCategory->name }}" disabled>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="remaining_qty" class="text-lg">
                            {{ __('الكمية الموجودة') . " ($materialCategory->unit)" }}</label>
                        <div class="flex">
                            <input type="text" name="remaining_qty" id="remaining_qty"
                                class="bg-gray-100 text-gray-600 border-gray-300 border rounded w-full py-2 px-2"
                                value="{{ $materialCategory->total_qty . ' ' . $materialCategory->unit }}" disabled>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="spent_qty" class="text-lg">
                            {{ __('الكمية المراد انفاقها') . " ($materialCategory->unit)" }}</label>
                        <div class="flex">
                            <input type="number" name="spent_qty" id="spent_qty"
                                class="bg-gray-50 border-gray-300 border rounded w-full py-2 px-2" min="0.01"
                                step="0.01" max="{{ $materialCategory->total_qty }}" required />
                        </div>
                    </div>
                    <div class="mt-3">
                        <div>
                            <label for="on_asset">انفاق على أصل</label>
                            <input type="checkbox" name="on_asset" id="on_asset">
                        </div>

                        <select name="asset_id" id="asset_id"
                            class="bg-gray-50 border-gray-300 border rounded w-full text-right mt-2 hidden">
                            <option></option>
                            @foreach (\App\Models\FixedAsset::all() as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->invertory->name_and_path . '/' . $item->name }}</option>
                            @endforeach
                        </select>
                        <div id="asset_attributes">

                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="date" class="text-lg">
                            {{ __('تاريخ انفاق المادة') }}</label>
                        <div class="flex">
                            <input type="date" name="date" id="date"
                                class="bg-gray-50 border-gray-300 border rounded w-full text-right" required>
                        </div>
                    </div>
                    <input type="hidden" name="type" value="material">
                </div>
            </div>
            <div class="mt-3 max-w-4xl mx-auto">
                <input type="submit" value="حفظ" id="submitBtn"
                    class="block py-3 px-4 bg-indigo-600 text-white rounded cursor-pointer">
            </div>
        </form>
    </div>
    @push('custom-scripts')
        <script>
            $('#on_asset').on('input', function() {
                $('#asset_id').slideToggle();
            });
            $('#asset_id').on('input', function(e) {
                $('#asset_attributes').slideUp();
                $.ajax({
                    type: "GET",
                    url: `/assets/${this.value}/getAttributes`,
                    success: function(response) {
                        let htmlString = response.attributes.map(att =>
                            `<div class="bg-gray-200 text-gray-600 text-lg font-semibold mt-2 rounded-lg px-4 py-2">${att.key}: ${att.value}</div>`
                        );
                        $('#asset_attributes').html(htmlString);
                        $('#asset_attributes').slideDown();

                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
