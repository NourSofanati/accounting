<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة مورد جديد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <form action="{{ route('vendors.store') }}" method="post" class="w-full">
                    @csrf
                    <div class="grid grid-cols-2 gap-5">
                        <div class="mb-5 col-span-1">
                            <x-jet-label for="name" value="{{ __('اسم المورد') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                        </div>
                        <div class="mb-5 col-span-1">
                            <x-jet-label for="phone" value="{{ __('رقم هاتف المورد') }}" />
                            <x-jet-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                :value="old('phone')" required autofocus autocomplete="phone" />
                        </div>
                        <div class="mb-5 col-span-2">
                            <x-jet-label for="address" value="{{ __('عنوان المورد') }}" />
                            <x-jet-input id="address" class="block mt-1 w-full" type="text" name="address"
                                :value="old('address')" required autofocus autocomplete="address" />
                        </div>
                    </div>
                    <input type="submit" value="إضافة المورد" class="bg-green-500 text-white font-bold rounded-xl px-5 py-3" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;">
                    <a class="mr-4" href="{{ route('vendors.index') }}">إلفاء</a>
                </form>
            </div>
        </div>
    </div>
    
</x-app-layout>
