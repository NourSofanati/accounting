<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('إنشاء حساب') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-5">
                    <form method="POST" action="{{ route('accounts.store') }}">
                        @csrf

                        <div>
                            <x-jet-label for="name" value="{{ __('اسم الحساب') }}" />
                            <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                        </div>
                        {{-- @include('accounts.selectAccount') --}}
                        <div class="mt-4">
                            <x-jet-label for="parent_id" value="{{ __('الحساب الأب') }}" />
                            <select name="parent_id" id="parent_id" required
                                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full">
                                @foreach ($accountTypes as $item)
                                    <optgroup label="◀{{ $item->name }}">
                                        @if ($item->accounts->count() > 0)
                                            @foreach ($item->accounts as $item)
                                                @include('accounts.listAccounts',['isTransaction'=>$isTransaction=false])
                                            @endforeach
                                        @endif
                                    </optgroup>
                                @endforeach
                            </select>

                        </div>
                        <div class="mt-5 flex">
                            <input type="submit" value="إضافة الحساب"
                                class="rounded-md shadow-md bg-indigo-600 text-white font-bold px-3 py-3 block w-50 hover:shadow-xl transition-shadow ease-linear duration-200"></a>
                            <a href="{{ route('accounts-chart') }}"
                                class="rounded-md bg-gray-100 text-gray-500 font-bold px-10 py-3 block mr-5 hover:shadow-xl transition-shadow ease-linear duration-200">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
