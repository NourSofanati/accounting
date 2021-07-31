<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة موظف جديد') }}
        </h2>
    </x-slot>
    <div class="p-12 ">
        <div class="p-5 w-5/12 mx-auto bg-white shadow-xl rounded ">
            <form action="{{ route('positions.store') }}" method="post">
                @csrf
                <label for="name">اسم المنصب</label>
                <input type="text" required name="name" class="w-full h-full border-1 border-gray-300 rounded mt-2">

                <input type="submit" value="إضافة المنصب" class="px-4 py-2 bg-indigo-500 text-white mt-3 rounded-lg"  onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;">
            </form>
        </div>
    </div>
</x-app-layout>
