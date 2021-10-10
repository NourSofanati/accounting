<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('vendors') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-5">
                <div class="flex">
                    <a href="{{ route('vendors.create') }}"
                        class="px-3 py-2 rounded text-white block shadow-md font-bold bg-lime hover:bg-lime-dark duration-100 transition-all cursor-pointer">إضافة
                        مورد
                        جديد</a>
                </div>
                <hr class=" my-4">
                <input type="text" name="search_query" id="search_query"
                    class="w-full bg-white shadow-inner py-4 px-4 border-2 border-dashed border-gray-300 mb-3.5 text-xl"
                    placeholder="إبحث 🔍" autocomplete="off">
                <div class="border-2 border-dashed p-2" id="searchResult">
                    @forelse ($vendors as $vendor)
                        <a class="flex bg-white shadow rounded-xl w-full mb-5"
                            href="{{ route('vendors.show', $vendor) }}">
                            <div class="p-5">
                                <img src="https://icon-library.com/images/vendor-icon-png/vendor-icon-png-7.jpg"
                                    class="h-20 rounded-full w-20 my-auto ring-4" />
                            </div>
                            <div class="p-5 text-right">
                                <h1 class="font-bold text-xl text-gray-700">
                                    {{ $vendor->name }}
                                </h1>
                                <h2 class="text-gray-600 font-semibold" dir="ltr">
                                    {{ $vendor->phone }}
                                </h2>
                                <p class="text-gray-600">
                                    {{ $vendor->address }}
                                </p>
                            </div>
                        </a>
                    @empty
                        لا يوجد مورّدون حاليا.
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script>
            let loading = false;
            $('#search_query').on('input', function() {
                if (!loading) {
                    htmlString =
                        `<div class="flex w-full h-full p-5"><span class="material-icons animate-spin md-48 mx-auto my-auto text-green-600">cached</span></div>`;
                    $('#searchResult').html(htmlString);
                    loading = true;
                }
            });

            $('#search_query').on('input', $.debounce(function() {
                console.log('making a request');
                $.ajax({
                    type: "GET",
                    url: "/search-vendors?search_query=" + this.value,
                    success: function(response) {
                        loading = false;
                        htmlString = response.map(vendor => `
                        <a class="flex bg-white shadow rounded-xl w-full mb-5"
                            href="/vendors/${vendor.id})">
                            <div class="p-5">
                                <img src="https://icon-library.com/images/vendor-icon-png/vendor-icon-png-7.jpg"
                                    class="h-20 rounded-full w-20 my-auto ring-4" />
                            </div>
                            <div class="p-5 text-right">
                                <h1 class="font-bold text-xl text-gray-700">
                                    ${vendor.name}
                                </h1>
                                <h2 class="text-gray-600 font-semibold" dir="ltr">
                                    ${vendor.phone}
                                </h2>
                                <p class="text-gray-600">
                                    ${vendor.address}
                                </p>
                            </div>
                        </a>
                        `);
                        $('#searchResult').html(htmlString);
                    }
                });
            }, 500));
        </script>
    @endpush
</x-app-layout>
