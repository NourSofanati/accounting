<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('الأرشيف') }}
        </h2>
    </x-slot>
    <div class="w-full p-12">
        <iframe src="https://diyarpower.com/AccountingArchives/archives.php" class="w-full h-screen"></iframe>
    </div>
</x-app-layout>
