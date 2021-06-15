<div class=" col-span-2">
    <hr class=" mb-3"/>
    
    <h1 class="text-lime font-bold text-3xl mb-4">
        النقد :
    </h1>
    <div class="grid grid-cols-2 gap-5">
        @foreach ($cashAccounts as $item)
            <div class="bg-white border px-4 py-4 border-gray-200 h-24 w-full block text-lime">
                <h1 class="text-2xl font-bold">
                    {{ number_format($item->balance()) . ' ' . $currency->sign }}
                </h1>
                <h2>
                    {{ $item->name }}
                </h2>
            </div>
        @endforeach
    </div>
</div>
