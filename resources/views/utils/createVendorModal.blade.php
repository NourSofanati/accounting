<div id="addVendorModal" class="absolute top-0 left-0 right-0 bottom-0 backdrop-blur-xl flex hidden">
    <div class="bg-white rounded my-auto mx-auto py-2 px-5 shadow-2xl border-2">
        <div class="flex modal-header w-full justify-between mb-5 border-b-2 pb-2">
            <h1 class="text-xl my-auto">إضافة موردين</h1>
            <button class="justify-end text-3xl my-auto" id="addVendorClose">&times;</button>
        </div>
        <div class="modal-form">
            <form id="addVendorForm" action="{{ route('addVendorModal') }}" method="post" enctype="multipart/form">
                @csrf
                <div class="mb-2">
                    <label for="name" class="text-lg">اسم المورد *</label>
                    <input type="text" name="name" id="vendorName"
                        class="w-full border rounded border-gray-400 bg-gray-50 mt-2" required>
                </div>
                <div class="mb-2">
                    <label for="address" class="text-lg">العنوان</label>
                    <input type="text" name="address" id="vendorAddress"
                        class="w-full border rounded border-gray-400 bg-gray-50 mt-2">
                </div>
                <div class="mb-2">
                    <label for="phone" class="text-lg">رقم الهاتف</label>
                    <input type="tel" name="phone" id="vendorPhone"
                        class="w-full border rounded border-gray-400 bg-gray-50 mt-2">
                </div>
                <button type="submit"
                    class="bg-green-500 text-lg mb-2 mt-4 px-4 py-2 text-white rounded shadow hover:shadow-xl hover:bg-green-400 transition duration-75">إضافة</button>
            </form>
        </div>
    </div>
</div>
@push('custom-scripts')
    <script>
        $('#addVendor').click(function(e) {
            e.preventDefault();
            $('#addVendorModal').removeClass('hidden');
        });
        $('#addVendorClose').click(function(e) {
            e.preventDefault();
            $('#addVendorModal').addClass('hidden');

        });
        $('#addVendorForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('addVendorModal') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#addVendorClose').trigger('click');
                    let htmlString = response.vendors.map(vendor =>
                        `<option value="${vendor.id}" ${vendor.name == e.target.name.value? 'selected' : ''}>${vendor.name}</option>`
                    );
                    $('#vendors').html(htmlString);
                }
            });
        });
    </script>
@endpush
