<div class="grid grid-cols-4 gap-5">
    @foreach ($materialCategory->materials->where('remaining_qty', '>', 0) as $material)
        <div class="bg-white border-2 rounded-md">
            @php
                $bgColor = 'bg-gray-100';
                if ($material->all_qty == $material->remaining_qty) {
                    $bgColor = 'bg-green-100';
                }
                if ($material->all_qty > $material->remaining_qty) {
                    $bgColor = 'bg-yellow-100';
                }
            @endphp
            <header class="{{ $bgColor }} p-4 text-center text-gray-600 font-bold text-xl">
                {{ $materialCategory->name }}
            </header>
            <section class="px-5 grid">
                <div class="grid grid-cols-2 border-b border-dashed py-2">
                    <p>سعر الشراء:</p>
                    <p>{{ number_format($material->price) }} ل.س</p>
                </div>
                <div class="grid grid-cols-2 border-b border-dashed py-2">
                    <p>الكمية:</p>
                    <p>{{ number_format($material->all_qty) . '/' . number_format($material->remaining_qty) }}
                    </p>
                </div>
            </section>
            <footer class="flex p-2 mt-3 bg-gray-50">
                <h1 class="text-sm text-gray-600">رقم الفاتورة:
                    {{ sprintf('%06d', $material->purchaseItem->purchase->id) }}</h1>
            </footer>
        </div>
    @endforeach
</div>
