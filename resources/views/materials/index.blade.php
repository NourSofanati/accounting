<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('المواد') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="flex gap-3 mb-4 ">
            <a id="addMaterialCategoryModalOpen"
                class="px-3 py-4 text-white block rounded-xl cursor-pointer hover:scale-105 transition-all duration-100 hover:shadow-xl shadow-md font-bold bg-green-400 ">
                تعريف مادة
            </a>
        </div>
        <div class="border-2 border-dashed p-4 ">
            <h1 class="text-2xl text-gray-700 mb-4">المواد المعرفة:</h1>
            @if ($materialCategories->count())
                <div class="w-full flex gap-4 flex-wrap">
                    @foreach ($materialCategories as $category)
                        <a href="{{ route('material-categories.show', $category) }}"
                            class="bg-white border-2 hover:scale-105 hover:shadow-2xl transition-all duration-100 cursor-pointer min-w-[250px]">
                            <section class="p-2  text-center  px-2">
                                <h2 class="font-bold text-xl pb-4 border-b text-gray-600 text-center">
                                    {{ $category->name }}
                                </h2>
                                <p class="text-lg text-gray-500">
                                    {{ $category->total_qty . ' ' . $category->unit }}</p>
                            </section>
                            <section class="p-2 text-center px-2">
                                <p class="text-lg text-gray-500">
                                    <span>القيمة:</span>
                                    <span class="font-bold text-green-500">{{ $category->total_remaining_price }}
                                        ل.س</span>
                                </p>
                            </section>
                        </a>
                    @endforeach
                </div>
            @else
                لا يوجد مشتريات حاليا.
            @endif
        </div>
    </div>
    @include('utils.createMaterialCategoryModal')
</x-app-layout>
