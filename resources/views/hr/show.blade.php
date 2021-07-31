<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الموظف ') . $employee->fullName() }}
        </h2>
    </x-slot>
    <div class="p-12">
        <div class="bg-white shadow rounded p-5">
            <div class="grid grid-cols-3">
                <div class="col-span-2">
                    <div>
                        <div class="flex flex-col mr-5 pt-3">
                            <h1 class=" font-semibold text-2xl ">{{ $employee->fullName() }}</h1>
                            <h2 class=" text-xl text-gray-600">
                                {{ $employee->invertory->name }} /
                                {{ $employee->position->name }}
                            </h2>
                            <p class=" font-thin text-lg text-gray-500">
                                {{ \Carbon\Carbon::parse($employee->birthDate)->diff(\Carbon\Carbon::now())->format('%y سنة') }}
                            </p>
                            <section id="buttons" class="mt-5">
                                <a href="{{ route('employees.edit', $employee) }}"
                                    class="bg-gray-500 hover:bg-gray-700 text-white rounded px-4 py-2">تعديل
                                    البيانات</a>
                                <a href="{{ route('paySalary', $employee) }}"
                                    class="bg-green-500 hover:bg-green-700 text-white rounded px-4 py-2">دفع سلفة</a>
                                <a href="{{ route('vacations.edit', $employee) }}"
                                    class="bg-indigo-500 hover:bg-indigo-700 text-white rounded px-4 py-2">تسجيل
                                    إجازات</a>
                                <a href="{{ route('bonus.edit', $employee) }}"
                                    class="bg-[#DF9A2C]  hover:bg-yellow-600 text-white rounded px-4 py-2">مكافآت
                                </a>
                            </section>
                        </div>
                    </div>


                </div>
                <div class="col-span-1 flex justify-end">
                    @if ($employee->picture)
                        <img src="{{ Storage::url('public/images/' . $employee->picture->uri) }}" alt=""
                            class="rounded-full border-8 border-blue-400 h-36">
                    @else
                        <img src="{{ asset('images/employee.png') }}" alt=""
                            class="rounded-full border-4 border-gray-300 h-36">
                    @endif
                </div>
            </div>
            <hr class="mt-10">
            <div class="grid grid-cols-4  gap-5 p-4 mt-5">


                <section id="details" class="col-span-2">
                    <div>
                        <label for="monthlySalary" class="text-xl pr-2">الراتب الشهري</label>
                        <input type="text" name="monthlySalary" id="monthlySalary"
                            class="w-full mt-3 p-2 rounded bg-gray-100 border-none" disabled
                            value="{{ $employee->monthlySalary }} ليرة سورية">
                    </div>
                    <div class="mt-5">
                        <label for="birthDate" class="text-xl pr-2">تاريخ الولادة</label>
                        <input type="text" name="birthDate" id="birthDate"
                            class="w-full mt-3 p-2 rounded bg-gray-100 border-none" disabled
                            value="{{ $employee->birthDate }}">
                    </div>
                    <div class="mt-5">
                        <label for="startDate" class="text-xl pr-2">تاريخ بدء العمل</label>
                        <input type="text" name="startDate" id="startDate"
                            class="w-full mt-3 p-2 rounded bg-gray-100 border-none" disabled
                            value="{{ $employee->startDate }}">
                    </div>
                    <div class="mt-5">
                        <label for="payday" class="text-xl pr-2">يوم قبض الراتب</label>
                        <input type="text" name="payday" id="payday"
                            class="w-full mt-3 p-2 rounded bg-gray-100 border-none" disabled
                            value="{{ $employee->payday }} من كل شهر">
                    </div>
                    <div class="mt-5">
                        <label for="invertory" class="text-xl pr-2">المكان</label>
                        <input type="text" name="invertory" id="invertory"
                            class="w-full mt-3 p-2 rounded bg-gray-100 border-none" disabled
                            value="{{ $employee->invertory->name }}">
                    </div>
                    <div class="mt-5">
                        <label for="position" class="text-xl pr-2">المنصب</label>
                        <input type="text" name="position" id="position"
                            class="w-full mt-3 p-2 rounded bg-gray-100 border-none" disabled
                            value="{{ $employee->position->name }}">
                    </div>
                    <div class="mt-5">
                        <label for="gender" class="text-xl pr-2">الجنس</label>
                        <input type="text" name="gender" id="gender"
                            class="w-full mt-3 p-2 rounded bg-gray-100 border-none" disabled
                            value="{{ __($employee->gender) }}">
                    </div>
                    <div class="mt-5">
                        <label for="gender" class="text-xl pr-2">الشهادات</label>
                        {{-- <input type="text" name="gender" id="gender"
                            class="w-full mt-3 p-2 rounded bg-gray-100 border-none" disabled
                            value="{{ __($employee->gender) }}"> --}}
                        @foreach ($employee->achievments as $item)
                            <div class="w-full mt-3 p-2 rounded bg-gray-100">
                                {{ $item->achievment }}
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5">

                    </div>
                </section>
                <section id="payments">
                    <h1 class="text-xl pr-2s">الدفعات المسجلة</h1>
                    <div class="grid  gap-3 mt-3">
                        {{-- @forelse ($employee->payments as $item)
                            <div class="bg-green-100 rounded p-2">
                                {{ $item->amount }} بتاريخ
                                {{ $item->payment_date }}
                            </div>
                            @empty
                            @endforelse
                            
                            @forelse ($employee->bonuses as $item)
                            <div class="bg-yellow-100 rounded p-2">
                                {{ $item->bonus_amount }} بتاريخ
                                {{ $item->date }}
                            </div>
                            @empty --}}
                        @forelse ($payments as $payment)

                            <div
                                class="{{ $payment['type'] != 'payment' ? 'bg-yellow-100' : 'bg-green-100' }} bg-green-100 rounded p-2">
                                {{ $payment['type'] != 'payment' ? 'جائزة بقيمة ' : ' سلفة بقيمة ' }}
                                {{ $payment['amount'] }} بتاريخ
                                {{ $payment['date'] }}
                            </div>
                        @empty
                            لا يوجد دفعات
                        @endforelse

                        @if ($employee->totalPayments() > 0 || $employee->totalBonuses() > 0)
                            <div class="bg-green-300 rounded p-2">
                                أجمالي تعاملاتي معه: <b>{{ $employee->totalPayments() + $employee->totalBonuses() }}
                                    ل.س</b>
                                <hr class="border-gray-500/20 my-4" />
                                <div class="grid grid-cols-2 text-center ">
                                    <p class=" font-bold ">اجمالي السلف:<br> {{ $employee->totalPayments() }} ل.س</p>
                                    <p class=" font-bold ">اجمال الجوائز:<br>{{ $employee->totalBonuses() }} ل.س</p>
                                </div>
                            </div>

                        @endif
                    </div>
                </section>
                <section id="bouns">
                    <h1 class="text-xl pr-2s">اجازات مسجلة</h1>
                    <div class="grid gap-3 mt-3">
                        @php
                            $total = 0;
                            $totalUnpaid = 0;
                        @endphp
                        @forelse ($employee->vacations as $item)
                            <div class="bg-indigo-100 rounded p-2">
                                اجازة
                                <b>{{ (strtotime($item->toDate) - strtotime($item->fromDate)) / 60 / 60 }}</b> ساعات
                                <b>{{ $item->paid ? 'مدفوعة' : 'غير مدفوعة' }}</b>
                                @if (!$item->paid)
                                    <br>
                                    تم خصم <b>
                                        {{ $item->transaction->creditTotal() }} ل.س
                                    </b>
                                @endif

                                <hr class="border-gray-500/20 my-2" />
                                <div class="text-left">
                                    {{ $item->fromDate }} <-- {{ $item->toDate }} </div>
                                </div>
                                @php
                                    if ($item->paid) {
                                        # code...
                                        $total += (strtotime($item->toDate) - strtotime($item->fromDate)) / 60 / 60;
                                    } else {
                                        $totalUnpaid += (strtotime($item->toDate) - strtotime($item->fromDate)) / 60 / 60;
                                    }
                                @endphp
                            @empty
                                لا يوجد إجازات مسجلة
                        @endforelse
                        @if ($total > 0)
                            <div class="bg-indigo-300 rounded p-2">
                                اجمالي ساعات الإجازات: <b>{{ $total + $totalUnpaid }} ساعة </b>
                                <hr class="border-gray-500/20 my-4" />
                                <div class="grid grid-cols-2 text-center">
                                    <p class=" font-bold">ساعات مدفوعة:<br />{{ $total }} ساعة</p>
                                    <p class=" font-bold">ساعات غير مدفوعة: <br />{{ $totalUnpaid }} ساعة</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
            <hr class="my-5">

        </div>
    </div>
</x-app-layout>
