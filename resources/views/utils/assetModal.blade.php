<div class="absolute top-0 left-0 right-0 bottom-0 backdrop-blur-xl flex hidden" data-id={{ $asset->id }}
    data-assetModal>
    <div class="bg-white rounded my-auto mx-auto py-2 px-5 shadow-2xl border-2">
        <div class="flex modal-header w-full justify-between mb-5 border-b-2 pb-2">
            <h1 class="text-xl my-auto">تفاصيل العنصر</h1>
            <button class="justify-end text-3xl my-auto" data-id={{ $asset->id }}
                data-isCloseAssetModal>&times;</button>
        </div>
        <div class="flex flex-col gap-2">
            @foreach ($asset->purchaseItem->attributes as $attribute)
                <div class="bg-gray-100 rounded-lg text-gray-600 py-2 px-4">
                    {{ $attribute->key . ': ' . $attribute->value }}
                </div>
            @endforeach
            <div class="bg-gray-100 rounded-lg text-gray-600 py-2 px-4">
                {{ 'المستودع الحالي' . ': ' . $asset->invertory->name }}
            </div>
            <div class="bg-gray-100 rounded-lg text-gray-600 py-2 px-4">
                تاريخ الشراء: <bdi>{{ $asset->purchaseItem->purchase->date }}</bdi>
            </div>
            <a href="{{ route('purchases.show', $asset->purchaseItem->purchase) }}"
                class="bg-gray-100 rounded-lg text-gray-600 py-2 px-4 hover:bg-green-500 transition-all duration-100 hover:text-white hover:scale-105">
                رقم الفاتورة: {{ sprintf('%06d', $asset->purchaseItem->purchase->id) }}
            </a>
        </div>
        <div class="modal-form">
            <form data-changeInvertoryForm action="{{ route('changeInvertoryModal') }}" method="POST">
                @csrf
                <input type="hidden" name="asset_id" value="{{ $asset->id }}">
                <div class="mt-3">
                    <label for="depreciation_rate">
                        نسبة الإهتلاك %
                    </label>
                    <input name="depreciation_rate" id="depreciation_rate" type="number" step="0.1" min="0" max="100"
                        value="{{ $asset->depreciation_rate ?? 0 }}"
                        class="w-full h-full border-1 border-gray-300 rounded mt-2" />
                </div>
                <div class="mt-3">
                    <label for="invertory_id">
                        نقل لمخزن
                    </label>
                    <select name="invertory_id" id="invertory_id"
                        class="w-full h-full border-1 border-gray-300 rounded mt-2">
                        @foreach (\App\Models\Invertory::all() as $inv)
                            <option value="{{ $inv->id }}"
                                {{ $asset->invertory_id == $inv->id ? 'selected' : '' }}>
                                {{ $inv->name_and_path() }}
                            </option>

                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="bg-green-500 text-lg mb-2 mt-4 px-4 py-2 text-white rounded shadow hover:shadow-xl hover:bg-green-400 transition duration-75">حفظ</button>
            </form>
        </div>
    </div>
</div>
@push('custom-scripts')
    <script>
        $('[data-isShowAssetModal][data-id={{ $asset->id }}]').click(function(e) {
            e.preventDefault();
            $('[data-assetModal][data-id={{ $asset->id }}]').removeClass('hidden');
        });
        $('[data-isCloseAssetModal][data-id={{ $asset->id }}]').click(function(e) {
            e.preventDefault();
            $('[data-assetModal][data-id={{ $asset->id }}]').addClass('hidden');
        });
        // $('#changeInvertoryForm').submit(function(e) {
        //     e.preventDefault();
        //     let formData = new FormData(this);
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('changeInvertoryModal') }}",
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         success: function(response) {
        //             location.reload();
        //         }
        //     });
        // });
    </script>
@endpush
