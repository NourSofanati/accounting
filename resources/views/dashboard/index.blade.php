<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('لوحة التحكم') }}
        </h2>
    </x-slot>
    <div class="p-12">
        <section id="outstanding" class="text-3xl">
            <div class="grid mb-14 gap-1 grid-cols-3 max-w-full place-items-center text-center">
                @forelse ($invoices as $key=> $item)
                    @switch($key)
                        @case("retains")
                        @case("paid")
                        @case("recievables")
                        <div class="">
                            <h1 class="text-4xl text-indigo-500">
                                {{ $currency->sign.' '.number_format($item) }}
                            </h1>
                            <span class="text-xl text-gray-500">{{ __($key) }}</span>
                        </div>
                    @endswitch
                @empty

                @endforelse
            </div>
        </section>
        <img class="mx-auto my-5" src="{{asset('images/1.png')}}"/>
        <img class="mx-auto my-5" src="{{asset('images/2.png')}}"/>
        <img class="mx-auto my-5" src="{{asset('images/3.png')}}"/>
        <img class="mx-auto my-5" src="{{asset('images/4.png')}}"/>
        <img class="mx-auto my-5" src="{{asset('images/5.png')}}"/>
        <div class=" h-72">

            <canvas id="myChart"></canvas>
        </div>
    </div>
    @section('footerScripts')

        <script>
            var ctx = document.getElementById('myChart');
            var expenseData = {!! json_encode($expenseAccounts) !!};
            var expenseLabels = expenseData.map(e => e.name);
            console.log(expenseData);
            let maxCallback2 = (acc, cur) => acc += cur;
            var months = [{
                    "abbreviation": "Jan",
                    "name": "January"
                },
                {
                    "abbreviation": "Feb",
                    "name": "February"
                },
                {
                    "abbreviation": "Mar",
                    "name": "March"
                },
                {
                    "abbreviation": "Apr",
                    "name": "April"
                },
                {
                    "abbreviation": "May",
                    "name": "May"
                },
                {
                    "abbreviation": "Jun",
                    "name": "June"
                },
                {
                    "abbreviation": "Jul",
                    "name": "July"
                },
                {
                    "abbreviation": "Aug",
                    "name": "August"
                },
                {
                    "abbreviation": "Sep",
                    "name": "September"
                },
                {
                    "abbreviation": "Oct",
                    "name": "October"
                },
                {
                    "abbreviation": "Nov",
                    "name": "November"
                },
                {
                    "abbreviation": "Dec",
                    "name": "December"
                }
            ];
            var exp = expenseData.map(d => d.expenses.map(e => e.dr).reduce(maxCallback2, 0));
            var inc = expenseData.map(d => d.income.map(e => e.cr).reduce(maxCallback2, 0));
            exp.map((e, i) => i > 0 ? exp[i] += exp[i - 1] : exp[i]);
            inc.map((e, i) => i > 0 ? inc[i] += inc[i - 1] : inc[i]);
            let curDate = new Date();
            let currMonth = curDate.getMonth();
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: expenseData.map((d, i) => months[i].abbreviation),
                    datasets: [{
                        label: 'd9',
                        data: [0,123,32,-21],
                        fill: {
                            above: 'blue',
                            below: 'red',
                            target: {
                                value: 0
                            }
                        }
                    }]
                },
                options: {
                    
                    maintainAspectRatio: false,
                }
            });

        </script>
    @endsection

</x-app-layout>
