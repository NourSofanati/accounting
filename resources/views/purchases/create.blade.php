<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('شراء أصول') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <form action="{{ route('purchases.store') }}" method="post" id="assetsForm">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-lg rounded py-6">
                @csrf
                @include('purchases.header',['recieptName'=>'شراء '])
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
                                    <option value="{{ $invertory->id }}">{{ $invertory->name_and_path }}</option>
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
                    <input type="hidden" name="type" value="asset">

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

                <div class="bg-indigo-600/30 hover:bg-indigo-600 hover:shadow-2xl transition duration-75 text-white font-bold text-3xl flex rounded cursor-pointer"
                    id="addCard">
                    <span class="mx-auto my-auto">إضافة عنصر <span class="material-icons">add</span></span>
                </div>
            </div>
            <div class="mt-3 max-w-7xl mx-auto">
                <input type="submit" value="حفظ" class="block py-3 px-4 bg-indigo-600 text-white rounded cursor-pointer"
                    onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;">
            </div>
        </form>
    </div>
    <datalist id="attribute" class="px-4 border-gray-300 rounded">
        <option value="الحجم">
        <option value="الوزن">
        <option value="اللون">
        <option value="المساحة">
        <option value="الرقم التسلسلي">
        <option value="الشركة المصنعة">
        <option value="رقم النمرة">
        <option value="السنة التصنيع">
        <option value="رقم الموديل">
        <option value="بلد المنشأ">
    </datalist>
    @include('utils.createVendorModal')
    @include('utils.createInvertoryModal')
    @push('custom-scripts')
        <script>
            //php artisan make:observer UserObserver --model=User
            let cardCount = 0;
            let attributeCount = 0;

            $('#addCard').click(function(e) {
                e.preventDefault();
                cardCount++;
                let cardTemplate = `<div class="bg-white rounded shadow-lg px-8 py-6" data-index="${cardCount}">
                    <div class="flex justify-between">
                        <h1 class="text-xl text-[#526BC5] font-bold py-2">عنصر جديد</h1>
                        <button data-isDeleteCardButton>
                            <span class="material-icons text-gray-400 hover:text-gray-600">delete</span>
                        </button>
                    </div>
                    <div class="grid grid-cols-3 mt-4">
                        <label for="item[${cardCount}][item_name]" class="my-auto">اسم العنصر:</label>
                        <input type="text" name="item[${cardCount}][item_name]" class="border-gray-300 w-full rounded col-span-2">
                    </div>
                    <div class="grid grid-cols-3 mt-4">
                        <label for="item[${cardCount}][price]" class="my-auto">السعر الافرادي:</label>
                        <input type="text" name="item[${cardCount}][price]" class="border-gray-300 w-full rounded col-span-2">
                    </div>
                    <div class="grid grid-cols-3 mt-4">
                        <label for="item[${cardCount}][qty]" class="my-auto">العدد:</label>
                        <input type="text" name="item[${cardCount}][qty]" class="border-gray-300 w-full rounded col-span-2">
                    </div>
                    <hr class="mt-4">
                    <div class="grid grid-cols-3 mt-4">
                        <p>خصائص أخرى</p>
                    </div>
                    <div class="other-attributes" data-index="${cardCount}">

                    </div>
                    <button class="w-full py-2 text-center rounded bg-gray-50 font-bold text-gray-800" data-index="${cardCount}"
                        data-addAttributeBtn>إضافة</button>

                </div>`;

                $('#cards').append(cardTemplate);
                $('[data-addAttributeBtn]').off('click').click(function(e) {
                    e.preventDefault();
                    attributeCount++;
                    let htmlString =
                        `<div class="grid grid-cols-3 mt-4 relative attribute-row" data-index="${this.dataset.index}" data-attributeIndex="${attributeCount}">
                            <input list="attribute" id="attribute[${this.dataset.index}][${attributeCount}]" name="item[${this.dataset.index}][attributes][${attributeCount}][key]" class="px-4 border-gray-300 rounded"
                                placeholder="الخاصية" />
                            <input type="text" name="item[${this.dataset.index}][attributes][${attributeCount}][value]" class="border-gray-300 w-full rounded col-span-2">
                            <span class="absolute top-0 bottom-0 -right-5 delete-button" data-index="${this.dataset.index}" data-attributeIndex="${attributeCount}" data-deleteAttribute>
                                <span class="material-icons text-gray-400 hover:text-red-500">
                                    delete
                                </span>
                            </span>
                        </div>`;
                    $(`[data-index=${this.dataset.index}] .other-attributes`).append(htmlString);
                    $('.delete-button').click(function(e) {
                        e.preventDefault();
                        this.parentElement.remove();
                    });
                });
                $('[data-isDeleteCardButton]').off('click').click(function(e) {
                    e.preventDefault();
                    this.parentElement.parentElement.remove();
                });
            });
            console.log(cardAttributes);
            $('[data-addAttributeBtn]').click(function(e) {
                attributeCount++;
                e.preventDefault();
                let htmlString =
                    `<div class="grid grid-cols-3 mt-4 relative attribute-row" data-index="${this.dataset.index}" data-attributeIndex="${attributeCount}">
                    <input list="attribute" id="attribute[${this.dataset.index}][${attributeCount}]" name="item[${this.dataset.index}][attributes][${attributeCount}][key]" class="px-4 border-gray-300 rounded"
                        placeholder="الخاصية" />
                    <input type="text" name="item[${this.dataset.index}][attributes][${attributeCount}][value]" class="border-gray-300 w-full rounded col-span-2">
                    <span class="absolute top-0 bottom-0 -right-5 delete-button" data-index="${this.dataset.index}" data-attributeIndex="${attributeCount}" data-deleteAttribute>
                        <span class="material-icons text-gray-400 hover:text-red-500">
                            delete
                        </span>
                    </span>
                </div>`
                $(`[data-index=${this.dataset.index}] .other-attributes`).append(htmlString);
                $('.delete-button').click(function(e) {
                    e.preventDefault();
                    this.parentElement.remove();
                });
            });
            $('.delete-button').click(function(e) {
                e.preventDefault();
                $(`[data-index=${this.dataset.index}] .attribute-row`).remove();
            });
        </script>
    @endpush
</x-app-layout>
