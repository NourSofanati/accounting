<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('المورد ') . $vendor->name }}
        </h2>
    </x-slot>
    <div class="p-12">
        <div class="bg-white shadow rounded p-5">
            <div class="grid grid-cols-3">
                <div class="col-span-2">
                    <div>
                        <div class="flex flex-col mr-5 pt-3">
                            <h1 class=" font-semibold text-2xl ">{{ $vendor->name }}</h1>
                            <h2 class=" text-xl text-gray-600 text-right " dir="ltr">
                                {{ $vendor->phone }}
                            </h2>
                            <h2 class=" text-lg text-gray-500 text-right" dir="ltr">
                                {{ $vendor->address }}
                            </h2>
                            <section id="buttons" class="mt-5">
                                <a href="#"
                                    class="px-3 py-1 rounded text-white  font-bold bg-lime hover:bg-lime-dark duration-100 transition-all cursor-pointer">تعديل
                                    البيانات</a>
                            </section>
                        </div>
                    </div>


                </div>
                <div class="col-span-1 flex justify-end">
                    <img src="https://lh3.googleusercontent.com/proxy/QFYt4j4cgj_-WOjq0Lmba1liUARCUVK74O86vwvK-2hNpzqSDJpjULGzq9pJ0K_lk0MHss8v9piM38m5cYqpGSejqSIvLy-kK9yORzxP6iE"
                        alt="" class="rounded-full ring-4 my-auto h-36">
                </div>
            </div>
            <hr class="mt-10">
            <div class="grid gap-5 p-4 mt-5">
                <section id="payments">
                    <h1 class="text-xl pr-2s">الفواتير</h1>
                    <div class="grid gap-3 mt-3">
                        @php
                            $totalPaid = 0;
                            $totalDue = 0;
                        @endphp
                        <div class="grid grid-cols-5 gap-5">
                            @forelse ($vendor->ExpenseReciept as $item)
                                <a href="{{ route('expenses.show', $item) }}"
                                    class=" flex bg-gray-50 p-5 shadow flex-col relative">
                                    <p class="text-gray-500 ">{{sprintf('%06d', $item->id)}}</p>
                                    <div class="text-center font-bold text-xl flex flex-col">
                                        {{ $item->issueDate }}
                                        <span class="text-green-500 font-semibold opacity-75">
                                            {{ $item->totalDue() == 0 ? 'مدفوعة' : '' }}
                                        </span>
                                        <span class="text-yellow-500 font-semibold ">
                                            {{ $item->totalPaid() > 0 && $item->totalDue() != 0 ? 'مدفوعة جزئيا' : '' }}
                                        </span>
                                        <span class="text-gray-500 font-semibold opacity-75">
                                            {{ $item->totalPaid() == 0 ? 'غير مدفوعة' : '' }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-2 text-black gap-2 py-2 bg-green-200 px-3 rounded mt-2">
                                        <span class="place-self-start">المبلغ المدفوع</span>
                                        <span
                                            class="place-self-end text-left font-semibold">{{ $item->totalPaid() }}</span>
                                    </div>
                                    <div class="grid grid-cols-2 text-black gap-2 py-2 bg-yellow-200 px-3 rounded mt-2">
                                        <span class="place-self-start">المبلغ المتبقي</span>
                                        <span
                                            class="place-self-end text-left  font-semibold">{{ $item->totalDue() }}</span>
                                    </div>
                                    <hr />
                                    <div class="grid grid-cols-2 gap-2 py-2 font-semibold px-3">
                                        <span class="place-self-start">قيمة الفاتورة</span>
                                        <span class="place-self-end text-left">{{ $item->total() }}</span>
                                    </div>
                                </a>
                                @php
                                    $totalPaid += $item->totalPaid();
                                    $totalDue += $item->totalDue();
                                @endphp
                            @empty
                                لا يوجد فواتير
                            @endforelse
                        </div>
                        <div class="bg-green-300 rounded p-2 mt-5">
                            إجمالي دفعاتي له: <p class=" font-bold">{{ $totalPaid }}</p>
                        </div>
                        <div class="bg-yellow-300 rounded p-2 mt-2">
                            مستحقات المورّد: <p class=" font-bold">{{ $totalDue }}</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
