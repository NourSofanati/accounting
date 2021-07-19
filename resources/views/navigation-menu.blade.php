<nav x-data="{ open: false }" class="border-gray-300 border-l">

    <!-- Responsive Navigation Menu -->
    <div class="bg-white text-black w-56 h-full ">
        <div class="bg-gray-700 font-black py-6 text-center text-white w-full">
            <a href="{{ route('dashboard') }}">الديار للطاقة</a>
        </div>
        <div class="pb-3 space-y-1">
            @if (session('currency_id') == 1)
                <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                    :name="'dashboard'" />
                <x-jet-responsive-nav-link href="{{ route('accounts-chart') }}"
                    :active="request()->routeIs('accounts-chart')" :name="'accounts-chart'" />
                <x-jet-responsive-nav-link href="{{ route('reports.index') }}"
                    :active="request()->routeIs('reports.index')" :name="'reports'" />
                <x-jet-responsive-nav-link href="{{ route('vendors.index') }}"
                    :active="request()->routeIs('vendors.index')" :name="'vendors'" />
                <x-jet-responsive-nav-link href="{{ route('purchases.index') }}"
                    :active="request()->routeIs('purchases.index')" :name="'purchases'" />
                <x-jet-responsive-nav-link href="{{ route('expenses.index') }}"
                    :active="request()->routeIs('expenses.index')" :name="'expenses'" />
                <x-jet-responsive-nav-link href="{{ route('invoices.index') }}"
                    :active="request()->routeIs('invoices.index')" :name="'invoices'" />
                <x-jet-responsive-nav-link href="{{ route('customers.index') }}"
                    :active="request()->routeIs('customers.index')" :name="'customers'" />
                <x-jet-responsive-nav-link href="{{ route('taxes.index') }}"
                    :active="request()->routeIs('taxes.index')" :name="'taxes'" />
                <x-jet-responsive-nav-link href="{{ route('invertories.index') }}"
                    :active="request()->routeIs('invertories.index')" :name="'invertories'" />
                <x-jet-responsive-nav-link href="{{ route('employees.index') }}"
                    :active="request()->routeIs('employees.index')" :name="'employees'" />
                <x-jet-responsive-nav-link href="{{ route('archives') }}" :active="request()->routeIs('archives')"
                    :name="'archives'" />
            @else
                <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')"
                    :name="'dashboard'" />
                <x-jet-responsive-nav-link href="{{ route('accounts-chart') }}"
                    :active="request()->routeIs('accounts-chart')" :name="'accounts-chart'" />
                <x-jet-responsive-nav-link href="{{ route('reports.index') }}"
                    :active="request()->routeIs('reports.index')" :name="'reports'" />
                <x-jet-responsive-nav-link href="{{ route('vendors.index') }}"
                    :active="request()->routeIs('vendors.index')" :name="'vendors'" />
                <x-jet-responsive-nav-link href="{{ route('purchases.index') }}"
                    :active="request()->routeIs('purchases.index')" :name="'purchases'" />
                <x-jet-responsive-nav-link href="{{ route('expenses.index') }}"
                    :active="request()->routeIs('expenses.index')" :name="'expenses'" />
                <x-jet-responsive-nav-link href="{{ route('invertories.index') }}"
                    :active="request()->routeIs('invertories.index')" :name="'invertories'" />
                <x-jet-responsive-nav-link href="{{ route('archives') }}" :active="request()->routeIs('archives')"
                    :name="'archives'" />
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            {{-- <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    
                @endif

                <div>
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white">{{ Auth::user()->email }}</div>
                </div>
            </div> --}}

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                {{-- <x-jet-responsive-nav-link href="{{ route('profile.show') }}"
                    :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-jet-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}"
                        :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Logout') }}
                    </x-jet-responsive-nav-link>
                </form> --}}

                <!-- Team Management -->
                {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-50">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-jet-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-jet-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-jet-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-jet-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-50">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team :team="$team" component="jet-responsive-nav-link" />
                    @endforeach
                @endif --}}

            </div>
        </div>

        <ul class="pr-4 hidden" data-isHideable>
            <li> <a href="{{ route('setCurrency', 1) }}"
                    class="{{ session('currency_id') == 1 ? 'text-black' : 'text-gray-300' }}">SYP</a>
            </li>
            <li> <a href="{{ route('setCurrency', 2) }}"
                    class="{{ session('currency_id') == 2 ? 'text-black' : 'text-gray-300' }}">USD</a>
            </li>
            <li> <a href="{{ route('exchange.index') }}">تحويل عملة</a></li>

        </ul>
         <a href="{{ route('reset') }}">تصفير البرنامج</a>

    </div>
</nav>
