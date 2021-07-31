<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('اصدار تقرير الحركة اليومية') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div data-printable>
                    <div class="flex justify-between pb-8">
                        <div>
                            <h1 class="font-semibold text-4xl pb-5" style="color:#526BC5">
                                الحركة اليومية
                            </h1>
                            الديار للطاقة
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 216 298"
                            fill="none">
                            <circle cx="193.5" cy="22.5" r="22.5" fill="#526BC5"></circle>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M171 106V194H170.875C168.812 226.93 141.45 253 108 253C73.2061 253 45 224.794 45 190C45 155.206 73.2061 127 108 127V126.995C108.166 126.998 108.333 127 108.5 127C120.926 127 131 116.926 131 104.5C131 92.0736 120.926 82 108.5 82C108.333 82 108.166 82.0018 108 82.0054V82C48.3532 82 0 130.353 0 190C0 249.647 48.3532 298 108 298C166.308 298 213.823 251.794 215.927 194H216V190V106H215.951C215.983 105.504 216 105.004 216 104.5C216 92.0736 205.926 82 193.5 82C181.074 82 171 92.0736 171 104.5C171 105.004 171.017 105.504 171.049 106H171Z"
                                fill="#526BC5"></path>
                        </svg>
                    </div>
                    <div class="my-10">
                        <form method="post" action="{{ route('logbook.store') }}" class="flex flex-col">
                            @csrf
                            <div>
                                <x-jet-label for="fromDate">من تاريخ</x-jet-label>
                                <x-jet-input type="date" required name="fromDate" value="{{ $today }}" />
                            </div>
                            <div class="mt-2">
                                <x-jet-label for="enableRange">ليوم واحد؟</x-jet-label>
                                <x-jet-input type="checkbox" required name="enableRange" id="enableRange" />
                            </div>
                            <div class="mt-2" id="hideOnEnable">
                                <x-jet-label for="toDate">إلى تاريخ</x-jet-label>
                                <x-jet-input type="date" name="toDate" id="enableOnChecked" />
                            </div>
                            
                            <input type="submit" value="طلب التقرير" onClick="this.disabled=true; this.value='جاري المعالجة...';this.form.submit();return false;"
                                class=" mt-5 rounded px-5 bg-lime hover:bg-lime-dark transition duration-75 py-2 text-white font-bold " />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('footerScripts')
        <script>
            document.getElementById('enableRange').onclick = event => {
                document.getElementById('enableOnChecked').disabled = event.target.checked;
                if (event.target.checked)
                    document.getElementById('hideOnEnable').classList.add('hidden');
                else
                    document.getElementById('hideOnEnable').classList.remove('hidden');
            }
        </script>
    @endsection
</x-app-layout>
