<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('dashboard') }}
        </h2>
    </x-slot>
    <div class="w-full p-12">
        <div class="grid grid-cols-2 gap-6 ">
            <div class="bg-white border border-gray-200">
                <header class="px-4 py-2 border-b border-gray-200">
                    إجمالي الفواتير
                </header>
                <section>
                    <p class="p-2">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit consectetur vero voluptatum obcaecati sapiente expedita eum commodi esse non ipsa.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit consectetur vero voluptatum obcaecati sapiente expedita eum commodi esse non ipsa.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit consectetur vero voluptatum obcaecati sapiente expedita eum commodi esse non ipsa.
                    </p>
                </section>
            </div>
            @include('dashboard.quick-actions')
            @include('dashboard.invoices-summary')
        </div>
    </div>

</x-app-layout>
