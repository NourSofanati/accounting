<div id="addInvertoryModal" class="absolute top-0 left-0 right-0 bottom-0 backdrop-blur-xl flex hidden">
    <div class="bg-white rounded my-auto mx-auto py-2 px-5 shadow-2xl border-2">
        <div class="flex modal-header w-full justify-between mb-5 border-b-2 pb-2">
            <h1 class="text-xl my-auto">إضافة مخازن</h1>
            <button class="justify-end text-3xl my-auto" id="addInvertoryClose">&times;</button>
        </div>
        <div class="modal-form">
            <form id="addInvertoryForm" action="{{ route('addInvertoryModal') }}" method="post">
                @csrf
                <div class="mt-3">
                    <label for="name">
                        اسم المستودع
                    </label>
                    <input type="text" name="name" id="name" class="w-full h-full border-1 border-gray-300 rounded mt-2"
                        required>
                </div>
                <div class="mt-3">
                    <label for="parent_id">
                        داخل المستودع
                    </label>
                    <select name="parent_id" id="parent_id" class="w-full h-full border-1 border-gray-300 rounded mt-2">
                        {{-- <option value="">لا يوجد مستودع حاوي</option>
                        @forelse ($invertories as $item)
                            <option value="{{ $item->id }}">{{ $item->name_and_path }}</option>
                        @empty

                        @endforelse --}}
                    </select>
                </div>
                <button type="submit"
                    class="bg-green-500 text-lg mb-2 mt-4 px-4 py-2 text-white rounded shadow hover:shadow-xl hover:bg-green-400 transition duration-75">إضافة</button>
            </form>
        </div>
    </div>
</div>
@push('custom-scripts')
    <script>
        $('#addInvertory').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "get",
                url: "{{ route('getInvertories') }}",
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#parent_id').html(response.htmlString);
                }
            });
            $('#addInvertoryModal').removeClass('hidden');
        });
        $('#addInvertoryClose').click(function(e) {
            e.preventDefault();
            $('#addInvertoryModal').addClass('hidden');

        });
        $('#addInvertoryForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('addInvertoryModal') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    $('#invertories').html(response.htmlString);
                    $('#addInvertoryClose').trigger('click');
                }
            });
        });
    </script>
@endpush
