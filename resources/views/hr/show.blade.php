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
                                <a href="{{ route('paySalary', $employee) }}"
                                    class="bg-green-500 hover:bg-green-700 text-white rounded px-4 py-2">دفع سلفة</a>
                                <a href="{{ route('employees.edit', $employee) }}"
                                    class="bg-indigo-500 hover:bg-indigo-700 text-white rounded px-4 py-2">تعديل
                                    البيانات</a>
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
            <div class="grid grid-cols-2  gap-5 p-4 mt-5">


                <section id="details" class="">
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
                                {{$item->achievment}}
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5">
                        
                    </div>
                </section>
                <section id="payments">
                    <h1 class="text-xl pr-2s">الدفعات المسجلة</h1>
                    <div class="grid gap-3 mt-3">
                        @php
                            $total = 0;
                        @endphp
                        @forelse ($employee->payments as $item)
                            <div class="bg-green-100 rounded p-2">
                                {{ $item->amount }} بتاريخ
                                {{ $item->payment_date }}
                            </div>
                            @php
                                $total += $item->amount;
                            @endphp
                        @empty

                        @endforelse
                        @if ($total > 0)
                            <div class="bg-green-300 rounded p-2">
                                أجمالي تعاملاتي معه: <p class=" font-bold">{{ $total }}</p>
                            </div>

                        @endif
                    </div>
                </section>
            </div>
            <hr class="my-5">

        </div>
    </div>
</x-app-layout>
