@props(['active', 'name'])

@php
$classes = $active ?? false ? 'flex pl-3 pr-4 py-3 text-sm text-white bg-lime focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out' : 'flex pl-3 pr-4 py-3 text-sm hover:bg-gray-100 hover:border-gray-300 hover:text-black focus:outline-none focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <span class="px-2">
        @include('icons.'.$name)
    </span>
    {{ __($name) }}
</a>
