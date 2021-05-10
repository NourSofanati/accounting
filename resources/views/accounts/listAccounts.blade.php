@if (isset($isTransaction) && $isTransaction == true)
    
    @if ($item->children->count() == 0)
        <option value="{{ $item->id }}">{{ $item->name }}</option>
    @endif
@else
    <option value="{{ $item->id }}">{{ $item->name }}</option>
@endif


@if ($item->children)

    @foreach ($item->children as $item)
        @include('accounts.listAccounts',['item'=>$item,'isTransaction'=>$isTransaction])
    @endforeach


@endif
