@livewire('account-item',['item'
=>$item,'depth'=>$depth,'currency'=>$currency,'currency_rate'=>$currency_rate],key($item->id))
@if ($item->children->count())
    @php
        $depth++;
    @endphp
    @foreach ($item->children as $item)
        @include('layouts.list',$item)
    @endforeach
@endif


@section('footerScripts')
    <script>
        let accounts = document.querySelectorAll('[data-depth]');
        let accountsArr = Array.from(accounts);
        let accountsThatCanBeShown = accountsArr.filter(acc => acc.dataset.depth >= 1)
        accountsThatCanBeShown.forEach(acc => acc.classList.add('sr-only'));
        let btnsArr = Array.from(document.querySelectorAll('[data-expandButton]'));
        btnsArr.forEach(btn => {
            btn.onclick = e => {
                btn.dataset.expandedStatus = btn.dataset.expandedStatus == 'expanded' ? 'collapsed' :
                    'expanded';
                btn.innerText = btn.dataset.expandedStatus == "expanded" ? '-' : '+';
                collapseChildren(btn.dataset.res);
                refresh();
            }
        });

        function expand() {
            btnsArr.filter(btn => btn.dataset.expandedStatus == 'expanded').forEach(btn => {
                accountsThatCanBeShown.filter(acc => acc.dataset.parentid == btn.dataset.res).forEach(
                    acc => {
                        acc.classList.remove('sr-only');
                    });
            })
        }

        function collapse() {
            btnsArr.filter(btn => btn.dataset.expandedStatus == 'collapsed').forEach(btn => {
                accountsThatCanBeShown.filter(acc => acc.dataset.parentid == btn.dataset.res).forEach(
                    acc => {
                        acc.classList.add('sr-only');
                    });
            })
        }

        function refresh() {
            collapse();
            expand();
        }

        function collapseChildren(accountid) {
            btnsArr.filter(btn => btn.dataset.xparentid == accountid).forEach(btn => {
                collapseChildren(btn.dataset.res);
                btn.innerText = '+';
                btn.dataset.expandedStatus = 'collapsed';
            });
        }

        refresh();
    </script>
@endsection
