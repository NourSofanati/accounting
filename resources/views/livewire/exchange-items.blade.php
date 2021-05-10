<div class="rounded bg-white shadow-xl p-5">
    <form action="{{ route('exchange.store') }}" method="post">
        @csrf

        <header>
            <div class="flex justify-between pb-8 ">
                <div>
                    <h1 class="font-semibold text-4xl pb-5" style="color:#526BC5">
                        تحويل عملة
                    </h1>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 216 298" fill="none">
                    <circle cx="193.5" cy="22.5" r="22.5" fill="#526BC5"></circle>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M171 106V194H170.875C168.812 226.93 141.45 253 108 253C73.2061 253 45 224.794 45 190C45 155.206 73.2061 127 108 127V126.995C108.166 126.998 108.333 127 108.5 127C120.926 127 131 116.926 131 104.5C131 92.0736 120.926 82 108.5 82C108.333 82 108.166 82.0018 108 82.0054V82C48.3532 82 0 130.353 0 190C0 249.647 48.3532 298 108 298C166.308 298 213.823 251.794 215.927 194H216V190V106H215.951C215.983 105.504 216 105.004 216 104.5C216 92.0736 205.926 82 193.5 82C181.074 82 171 92.0736 171 104.5C171 105.004 171.017 105.504 171.049 106H171Z"
                        fill="#526BC5"></path>
                </svg>
            </div>
            <div class="flex justify-between pb-8">
                <div class="">
                    <div class="flex flex-col">
                        <span class="text-gray-500">تاريخ تحويل العملة</span>
                        <input type="date" name="issueDate" id="issueDate" class="border-none text-right text-xs">
                    </div>
                </div>
                <div class="">
                    <div class="flex flex-col pt-4">
                        <span class="text-gray-500">سعر العملة</span>
                        <input type="number" name="currency_value" id="currnecy_value" placeholder="price"
                            class="border-0" value="{{ $USDprice }}">
                    </div>
                </div>
            </div>
            <div class="rounded h-1 w-full my-5" style="background: #526BC5"></div>
            <div class="py-2">
                <x-jet-label for="exchange_value" value="قيمة التحويل من شجرة {{ $currency['code'] }}"> </x-jet-label>
                <input type="number" name="exchange_value" id="exchange_value"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
            </div>
            <div class="py-2">
                <x-jet-label for="exchange_from" value="تحويل المبلغ من حساب"></x-jet-label>
                <select name="exchange_from" id="exchange_from"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    @foreach ($cashAccounts as $acc)
                        @foreach ($acc->children as $child)
                            <option value="{{ $child->id }}">{{ $child->name }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
            <div class="py-2">
                <x-jet-label for="exchange_to" value="تحويل المبلغ ل حساب"></x-jet-label>
                <select name="exchange_to" id="exchange_to"
                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                    @foreach ($cashAccounts as $acc)
                        @foreach ($acc->children as $child)
                            <option value="{{ $child->id }}">{{ $child->name }}</option>
                        @endforeach
                    @endforeach
                </select>
            </div>
        </header>

    </form>
</div>
