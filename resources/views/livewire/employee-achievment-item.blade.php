<div class=" flex flex-col justify-between mt-3">
    <h1>الشهادات والخبرات</h1>

    @foreach ($achievments as $index => $achievment)
        <div class="my-4 w-full flex border-collapse" key="{{ $index }}">
            <select wire:model.lazy='achievments.{{ $index }}.type'
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-r-md shadow-sm "
                name="achievments[{{$index}}][type]">
                <optgroup label="خبرة او شهادة">
                    <option value="certificate">
                        شهادة
                    </option>
                    <option value="experience">
                        خبرة
                    </option>
                </optgroup>
            </select>
            <input type="text" wire:model.lazy="achievments.{{ $index }}.achievment"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-l-md shadow-sm w-full"
                placeholder="الشهادة او الخبرة" name="achievments[{{ $index }}][achievment]" />
            <a wire:click.prevent="removeEntry({{ $index }})" class=" my-auto">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-150 h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </a>
        </div>
    @endforeach
    <div>
        <button wire:click.prevent="addEntry"
            class=" flex justify-center text-center px-1 w-full py-2 rounded text-xl cursor-pointer border border-dashed border-gray-300 hover:border-gray-500 hover:text-gray-600 hover:bg-gray-50 text-gray-400"><svg
                xmlns="http://www.w3.org/2000/svg" class="h-5 ml-5 w-5 my-auto" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            اضافة
            نفقة</button>
    </div>
</div>
