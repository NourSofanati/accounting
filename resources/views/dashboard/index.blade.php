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
                    <img src="{{ asset('images/graph1.PNG') }}" />
                </section>
            </div>
            @include('dashboard.quick-actions')

            @include('dashboard.invoices-summary',['invoices'=>$invoices,'currency'=>$currency])
            <div class="bg-white border border-gray-200">
                <header class="px-4 py-2 border-b border-gray-200">
                    إجمالي النفقات
                </header>
                <section class="py-3 grid grid-cols-2 place-items-center">
                    <div id="expenses-chart"></div>
                    <div id="labels" class="grid grid-cols-1 gap-1"></div>
                </section>
            </div>
            @include('dashboard.cash')
        </div>
    </div>

    @section('footerScripts')
        <script type="module">
            import Pie from "/js/classes/Pie.js";
            const container = document.getElementById('expenses-chart');
            let data = {!! json_encode($expenseAccounts) !!};
            drawChart(container);
            console.log(data);

            function hashLabel(x) {
                return x*x + x;
            }

            function drawChart(div) {
                let pie = new Pie("expenses-chart");
                data.forEach(e => {
                    pie.AddSlice(e.balance, e.id);
                    document.getElementById('labels').innerHTML +=
                        `<p style="border:1px solid hsl(${hashLabel(e.id)},75%,60%);padding:2px 5px;"><span style="background:hsl(${hashLabel(e.id)},75%,60%);display:inline-block;width:15px;">­</span> ${e.name} ${e.parent} : ${e.balance}</p>`
                });
            }
        </script>
    @endsection
</x-app-layout>
