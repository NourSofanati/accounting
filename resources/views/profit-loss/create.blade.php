<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('تحديد فترة تقرير الأرباح والخسائر') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('profitloss.store') }}" method="post"
                class="bg-white shadow rounded-xl mx-auto  p-5">
                @csrf
                <div>
                    <x-jet-label for="fromData" class="text-xl mb-1">من تاريخ</x-jet-label>
                    <x-jet-input type="date" required name="fromData" placeholder="الشهر" value="{{$firstDate}}" />
                </div>

                <div>
                    <x-jet-label for="toData" class="text-xl mt-5 mb-1">إلى تاريخ</x-jet-label>
                    <x-jet-input type="date" required name="toData" placeholder="الشهر" value="{{$lastDate}}" />
                </div>

                <input type="submit" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;" value="عرض تقرير الأرباح والخسائر"
                    class="bg-lime text-white font-bold px-5 py-1 mt-5 rounded-xl hover:bg-green-700 cursor-pointer">
            </form>
        </div>
    </div>
</x-app-layout>
