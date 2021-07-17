<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إضافة موظف جديد') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white shadow-lg rounded">
            <form action="{{ route('employees.store') }}" method="post" class="p-5 grid grid-cols-3"
                enctype="multipart/form-data">
                @csrf

                <div class=" col-span-2">
                    <div class="mt-3">
                        <label for="firstName">
                            الاسم
                        </label>
                        <input type="text" name="firstName" id="firstName"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required
                            value="{{ old('firstName') }}">
                    </div>
                    <div class="mt-3">
                        <label for="lastName">
                            الكنية
                        </label>
                        <input type="text" name="lastName" id="lastName"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required
                            value="{{ old('lastName') }}">
                    </div>
                    <div class="mt-3">
                        <label for="position_id">المنصب</label>
                        <select name="position_id" id="position_id"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2">
                            @forelse ($positions as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @empty
                                <option value="" disabled>لا يوجد مناصب</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="invertory_id">الموقع</label>
                        <select name="invertory_id" id="invertory_id"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2">
                            @forelse ($invertories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @empty
                                <option value="" disabled>لا يوجد مواقع</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="birthDate">
                            تاريخ الميلاد
                        </label>
                        <input type="date" name="birthDate" id="birthDate"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required
                            value="{{ old('birthDate') }}">
                    </div>
                    <div class="mt-3">
                        <label for="startDate">
                            تاريخ بدء العمل
                        </label>
                        <input type="date" name="startDate" id="startDate"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required
                            value="{{ old('startDate') }}">
                    </div>
                    <div class="mt-3">
                        <label for="gender">
                            الجنس
                        </label>
                        <select name="gender" id="gender" class="w-full h-full border-1 border-gray-300 rounded mt-2"
                            required>
                            <option value="male">ذكر</option>
                            <option value="female">أنثى</option>
                        </select>
                    </div>
                    <div class="mt-3">
                        <label for="payday">
                            يوم قبض الراتب
                        </label>
                        <input type="number" name="payday" id="payday"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required
                            value="{{ old('payday') }}">
                    </div>
                    <div class="mt-3">
                        <label for="monthlySalary">
                            الراتب الشهري
                        </label>
                        <input type="number" name="monthlySalary" id="monthlySalary"
                            class="w-full h-full border-1 border-gray-300 rounded mt-2" required
                            value="{{ old('monthlySalary') }}">
                    </div>
                </div>
                <div class=" col-span-1 p-5">
                    <div class="w-full">
                        <label
                            class="w-64 flex flex-col items-center px-4 py-24 bg-white text-blue rounded-lg shadow-lg tracking-wide uppercase border border-blue cursor-pointer hover:bg-blue hover:text-white hover:bg-blue-400 transition-all duration-150 mx-auto mt-5">
                            <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20">
                                <path
                                    d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                            </svg>
                            <span class="mt-2 text-base leading-normal">صورة الموظف</span>
                            <input type='file' class="hidden" name="image" />
                        </label>
                    </div>
                </div>
                {{-- <input type="file" multiple name="attachment[]" class="border border-dashed border-gray-400 text-sm py-3 mt-3 rounded-xl" placeholder="أرفق ملفات"/> --}}
                <div class="col-span-2">
                    <label for="attachment" class="block my-2">
                        الملفات المرفقة
                    </label>
                    <input type="file" multiple name="attachment[]"
                        class="block w-full border border-dashed border-gray-400 text-sm py-3 px-2 mt-3 rounded-xl"
                        placeholder="أرفق ملفات" />
                </div>
                <div class="col-span-2">
                    @livewire('employee-achievment-item')
                </div>
                <div class="col-span-3">
                    <hr class="my-5">
                    <input type="submit" value="إضافة الموظف"
                        class="bg-indigo-500 text-white px-4 py-2 rounded-lg shadow">
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
