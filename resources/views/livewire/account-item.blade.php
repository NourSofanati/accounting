<tr class="border-t border-b bg-white hover:bg-indigo-50 cursor-pointer" wire:click.prevent="showItem({{ $item }})">
    <td class=" px-4 text-right ">
        <div class="flex ">
            @if ($item->parent_id == null)
                @switch($item->accountType->name)
                    @case('أصول')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-6 w-6 ml-3 text-indigo-500">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    @break
                    @case('التزامات')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-6 w-6 ml-3 text-yellow-500	">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @break
                    @case('حقوق الملكية')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-6 w-6 ml-3 text-green-500	">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @break
                    @case('دخل')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-6 w-6 ml-3 text-blue-500	">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20" />
                        </svg>
                    @break
                    @case('نفقات')
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="h-6 w-6 ml-3 text-red-400	">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @break
                    @default

                @endswitch

            @else
                <div class="pr-{{ $depth * 4 }}">
                    <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3 ml-3 ">
                        <path
                            d="M0.646447 9.64645C0.451184 9.84171 0.451184 10.1583 0.646447 10.3536L3.82843 13.5355C4.02369 13.7308 4.34027 13.7308 4.53553 13.5355C4.7308 13.3403 4.7308 13.0237 4.53553 12.8284L1.70711 10L4.53553 7.17157C4.7308 6.97631 4.7308 6.65973 4.53553 6.46447C4.34027 6.2692 4.02369 6.2692 3.82843 6.46447L0.646447 9.64645ZM13 9.5L1 9.5L1 10.5L13 10.5L13 9.5Z"
                            fill="#7E7878" />
                        <line x1="12.5" y1="10" x2="12.5" stroke="#7E7878" />
                    </svg>
                </div>
            @endif
            <div class="flex flex-col">
                <div class="text-sm font-medium text-gray-900">
                    {{ $item->name }}
                </div>
                @if ($depth > 1)
                    <div class="text-sm text-gray-500">
                        {{ $item->parent->name }}
                    </div>
                @endif
            </div>
        </div>
    </td>
    <td class=" px-4 py-3">{{ $item->accountType->name }}</td>

    <td class=" px-4 py-6 ">
        <span>
            {{ $balance != 0 ? $balance : abs($balance) }}
        </span>
        <span class=" font-thin text-gray-400">
            {{ $currency->sign }}
        </span>
        <br>
        <span data-isHideable class="text-gray-400">({{ $usdBalance != 0 ? $usdBalance : abs($usdBalance) }})</span>
    </td>
</tr>
