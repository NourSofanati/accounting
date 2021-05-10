@livewire('account-item',['item'
=>$item,'depth'=>$depth,'currency'=>$currency],key($item->id))
@if ($item->children->count())
    @php
        $depth++;
    @endphp
    @foreach ($item->children as $item)
        @include('layouts.list',$item)
    @endforeach
@endif
