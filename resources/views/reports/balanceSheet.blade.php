<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('التقارير') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="flex justify-between pb-8 ">
                    <div>
                        <h1 class="font-semibold text-4xl pb-5" style="color:#526BC5">
                            الميزانية
                        </h1>
                        الديار للطاقة
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 216 298" fill="none">
                        <circle cx="193.5" cy="22.5" r="22.5" fill="#526BC5"></circle>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M171 106V194H170.875C168.812 226.93 141.45 253 108 253C73.2061 253 45 224.794 45 190C45 155.206 73.2061 127 108 127V126.995C108.166 126.998 108.333 127 108.5 127C120.926 127 131 116.926 131 104.5C131 92.0736 120.926 82 108.5 82C108.333 82 108.166 82.0018 108 82.0054V82C48.3532 82 0 130.353 0 190C0 249.647 48.3532 298 108 298C166.308 298 213.823 251.794 215.927 194H216V190V106H215.951C215.983 105.504 216 105.004 216 104.5C216 92.0736 205.926 82 193.5 82C181.074 82 171 92.0736 171 104.5C171 105.004 171.017 105.504 171.049 106H171Z"
                            fill="#526BC5"></path>
                    </svg>
                </div>
                <div class="my-10">
                    <h3 class="text-xl" style="color: #526BC5">{{ $types[0]['name'] }}</h3>
                    <div class="block w-full h-2 rounded-2xl mt-2" style="background:#526BC5"></div>
                    @foreach ($types[0]->accounts as $account)
                        @if ($account->balance() > 0)
                            <table class="min-w-full my-10">
                                <thead class="border-b">
                                    <tr>
                                        <th class="text-right px-3 py-4">{{ $account->name }}</th>
                                        <th class="text-left sr-only px-3 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($account->children as $child)
                                        <tr class="border-b border-t border-dashed ">
                                            <td class="text-right px-3 py-4"> {{ $child->name }}</td>
                                            <td class="text-left px-3 py-4"> {{ $child->balance() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t">
                                    <tr class="font-bold">
                                        <td class="text-right px-3 py-4">المجموع:</td>
                                        <td class="text-left px-3 py-4">{{ $account->balance() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    @endforeach
                    <div class="px-3">
                        <hr class="mb-1">
                        <hr>
                    </div>
                    <div class="w-full flex justify-between">
                        <div class="font-bold px-3 py-4">حساب الأصول الكلي</div>
                        <div class="font-bold px-3 py-4">{{ $types[0]->balance() }}</div>
                    </div>
                </div>
                <div class="my-10">
                    <h3 class="text-xl" style="color: #526BC5">{{ $types[1]['name'] }} + {{ $types[2]['name'] }}
                    </h3>
                    <div class="block w-full h-2 rounded-2xl mt-2" style="background:#526BC5"></div>
                    @foreach ($types[1]->accounts as $account)
                        @if ($account->balance())

                            <table class="min-w-full my-10">
                                <thead class="border-b">
                                    <tr>
                                        <th class="text-right px-3 py-4">{{ $account->name }}</th>
                                        <th class="text-left sr-only px-3 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($account->children as $child)
                                        @if ($child->balance() > 0)
                                            <tr class="border-b border-t border-dashed ">
                                                <td class="text-right px-3 py-4"> {{ $child->name }}</td>
                                                <td class="text-left px-3 py-4"> {{ $child->balance() }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot class="border-t">
                                    <tr class="font-bold">
                                        <td class="text-right px-3 py-4">المجموع:</td>
                                        <td class="text-left px-3 py-4">{{ $account->balance() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    @endforeach
                    <div class="mt-5">
                        <div class="px-3">
                            <hr class="mb-1">
                        </div>
                        <div class="w-full flex justify-between">
                            <div class="font-bold px-3 py-4">حساب الاتزامات الكلي</div>
                            <div class="font-bold px-3 py-4">{{ $types[1]->balance() }}</div>
                        </div>
                    </div>
                </div>
                <div class="my-10">
                    @foreach ($types[2]->accounts as $account)
                        @if ($account->balance())
                            <table class="min-w-full my-10">
                                <thead class="border-b">
                                    <tr>
                                        <th class="text-right px-3 py-4">{{ $account->name }}</th>
                                        <th class="text-left sr-only px-3 py-4"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($account->children as $child)
                                        <tr class="border-b border-t border-dashed ">
                                            <td class="text-right px-3 py-4"> {{ $child->name }}</td>
                                            <td class="text-left px-3 py-4"> {{ $child->balance() }}</td>
                                        </tr>
                                    @endforeach


                                </tbody>
                                <tfoot class="border-t">
                                    <tr class="font-bold">
                                        <td class="text-right px-3 py-4">المجموع:</td>
                                        <td class="text-left px-3 py-4">{{ $account->balance() }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @endif
                    @endforeach

                    <div class="mt-5">
                        <div class="px-3">
                            <hr class="mb-1">
                        </div>
                        <div class="w-full flex justify-between">
                            <div class=" px-3 py-4">الربح الصافي</div>
                            <div class=" px-3 py-4">
                                {{ $types[3]->balance() - $types[4]->balance() }}</div>
                        </div>
                        <div class="px-3">
                            <hr class="mb-1">
                        </div>
                        <div class="w-full flex justify-between">
                            <div class="font-bold px-3 py-4">حساب حقوق الملكية</div>
                            <div class="font-bold px-3 py-4">
                                {{ $types[2]->balance() + ($types[3]->balance() - $types[4]->balance()) }}</div>
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    <div class="px-3">
                        <hr class="mb-1">
                        <hr class="mb">
                    </div>
                    <div class="w-full flex justify-between">
                        <div class="font-bold px-3 py-4">حساب الاتزامات + حقوق الملكية الكلي</div>
                        <div class="font-bold px-3 py-4">{{ $types[1]->balance() + $types[2]->balance() + ($types[3]->balance() - $types[4]->balance())}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
