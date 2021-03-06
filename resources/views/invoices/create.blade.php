<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء فاتورة جديدة') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="p-5">
                    <div class="flex my-5">
                        <input type="submit" value="حفظ الفاتورة" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;"
                            class="bg-green-500 text-white font-bold px-5 py-3 rounded-xl hover:bg-green-700 cursor-pointer">
                        <a
                            class="bg-gray-200 text-gray-500 font-bold px-5 py-3 rounded-xl hover:bg-gray-300 cursor-pointer mr-5">إلغاء</a>
                    </div>

                    @livewire('invoice-items', ['cashAccounts' =>
                    $cashAccounts,'customers'=>$customers,'draftInvoice'=>$draftInvoice,'USDprice'=>$USDprice,'currency'=>$currency])
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
