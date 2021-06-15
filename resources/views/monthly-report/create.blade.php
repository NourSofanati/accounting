<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء فاتورة جديدة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('monthly-report.store') }}" method="post">
                @csrf
                <x-jet-input type="number" required name="month" placeholder="الشهر" value="1"/>
                <input type="submit" value="عرض تقرير الشهر"
                            class="bg-green-500 text-white font-bold px-5 py-3 rounded-xl hover:bg-green-700 cursor-pointer">
            </form>
        </div>
    </div>
</x-app-layout>
