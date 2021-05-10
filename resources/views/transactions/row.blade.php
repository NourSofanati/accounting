@if ($account->entries->count())
    @foreach ($account->entries as $entry)
        @if ($entry['currency_id'] == session('currency_id'))
            <tr class=" h-24 hover:bg-indigo-50 px-5 cursor-pointer">
                <td class="text-right flex flex-col align-middle box-border py-5 ">
                    <a href="{{ route('journals.show', $entry->transaction) }}"><span
                            class=" font-semibold block">{{ $entry->transaction->transaction_name }}</span></a>
                    <span class=" text-gray-400 block">{{ $account->name }}</span>
                </td>
                <td>{{ $entry->transaction->transaction_date }}</td>
                <td>{{ $entry->transaction->description ? $entry->transaction->description : '---' }}
                </td>
                <td>
                    {{ $entry->currency_value }}
                </td>
                <td class="text-left">{{ $entry->cr ? '-' : '' }}{{ $entry->cr | $entry->dr }}
                    <br>
                    <span class="text-gray-400">($
                        {{ number_format(($entry->cr | $entry->dr) / $entry->currency_value, 2) }}
                        )</span>
                </td>
            </tr>
        @endif
    @endforeach
@endif
@if ($account->children->count())
    @foreach ($account->children as $account)
        @include('transactions.row',['account'=>$account])
    @endforeach
@endif
