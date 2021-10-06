<div id="addMaterialCategoryModal" class="absolute top-0 left-0 right-0 bottom-0 backdrop-blur-xl flex hidden">
    <div class="bg-white rounded my-auto mx-auto py-2 px-5 shadow-2xl border-2">
        <div class="flex modal-header w-full justify-between mb-5 border-b-2 pb-2">
            <h1 class="text-xl my-auto">إضافة مخازن</h1>
            <button class="justify-end text-3xl my-auto" id="addMaterialCategoryModalClose">&times;</button>
        </div>
        <div class="modal-form">
            <form id="addMaterialCategoryForm" action="" method="post">
                @csrf
                <div class="mt-3">
                    <label for="name">
                        اسم المادة <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" class="w-full h-full border-1 border-gray-300 rounded mt-2"
                        required>
                </div>
                <div class="mt-3">
                    <label for="units">
                        وحدة القياس
                    </label>
                    <input list="units" type="text" name="unit" id="unit"
                        class="w-full h-full border-1 border-gray-300 rounded mt-2" required>
                </div>
                <button type="submit"
                    class="bg-green-500 text-lg mb-2 mt-4 px-4 py-2 text-white rounded shadow hover:shadow-xl hover:bg-green-400 transition duration-75">إضافة</button>
            </form>
        </div>
    </div>
</div>

<datalist id="units" class="w-full h-full border-1 border-gray-300 rounded mt-2">
    <option value="طن"></option>
    <option value="كيلو غرام"></option>
    <option value="غرام"></option>
    <option value="ميلي غرام"></option>
    <option value="اونصة"></option>
    <option value="رطل"></option>
    <option value="برميل"></option>
    <option value="لتر"></option>
    <option value="ميلي لتر"></option>
    <option value="كيلو متر"></option>
    <option value="متر"></option>
    <option value="سانتي متر"></option>
    <option value="ميلي متر"></option>
</datalist>
@push('custom-scripts')
    <script>
        $('#addMaterialCategoryModalOpen').click(function(e) {
            e.preventDefault();
            $('#addMaterialCategoryModal').removeClass('hidden');
        });
        $('#addMaterialCategoryModalClose').click(function(e) {
            e.preventDefault();
            $('#addMaterialCategoryModal').addClass('hidden');
        });
        $('#addMaterialCategoryForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('addMaterialCategoryModal') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#addMaterialCategoryModalClose').trigger('click');
                    location.reload(true);
                }
            });
        });
    </script>
@endpush
