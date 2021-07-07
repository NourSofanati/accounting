<a class=" relative p-1 border-gray-100 cursor-pointer "
    href="{{ route(strtolower(str_replace(array(" ","&"),"",$item)) . '.create') }}">
    <div class="h-3 w-3 bg-gray-400 rounded-full absolute mx-auto left-0 right-0 bottom-4 top-0">
    </div>
    <div class="bg-gray-400 rounded w-8 absolute right-0 left-0 top-1 mx-auto block h-2">
    </div>
    <div class="block border-8 border-gray-100 h-52 w-36 shadow hover:shadow-md transition-shadow duration-150 ">
        <div class="w-full h-full bg-white grid place-items-center border border-gray-200 hover:border-gray-300">
            <span class="w-10 h-10 text-lime-dark">
                @include('icons.reports.'.str_replace(array(" ","&"),"",$item))
            </span>
            <hr class="border-lime-dark border-2 block w-8/12 ">
            <div
                class="block bg-gray-100 w-8/12 h-1 rounded hover:animate-pulse hover:bg-gray-200 transition-all duration-75">
            </div>
            <div
                class="block bg-gray-100 w-8/12 h-1 rounded hover:animate-pulse hover:bg-gray-200 transition-all duration-75">
            </div>
            <div
                class="block bg-gray-100 w-8/12 h-1 rounded hover:animate-pulse hover:bg-gray-200 transition-all duration-75">
            </div>
            {{ __($name) }}
        </div>
    </div>
</a>
