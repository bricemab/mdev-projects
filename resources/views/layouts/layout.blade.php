
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <title>Projets - MDevelopment</title>
    <meta name="viewport" content="width&#x3D;device-width,&#x20;initial-scale&#x3D;1.0">
    <meta http-equiv="X-UA-Compatible" content="IE&#x3D;edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset("mdev/img/apple-touch-icon.png")}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset("mdev/img/favicon-32x32.png")}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset("mdev/img/favicon-16x16.png")}}">
    <link rel="shortcut icon" href="{{asset("mdev/img/favicon-16x16.png")}}" type="image/x-icon">
    <link rel="icon" href="{{asset("mdev/img/favicon-16x16.png/")}}" type="image/x-icon">

    <!-- Le styles -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/dayjs@1.11.11/dayjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.11/plugin/customParseFormat.min.js" integrity="sha512-FM59hRKwY7JfAluyciYEi3QahhG/wPBo6Yjv6SaPsh061nFDVSukJlpN+4Ow5zgNyuDKkP3deru35PHOEncwsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset("assets/js/MdevUtils.js")}}"></script>
    @vite('resources/css/app.css')
    @vite(['resources/css/app.css','resources/js/app.js'])
    <script>
        dayjs.extend(dayjs_plugin_customParseFormat);
    </script>
</head>

<body class="bg-white dark:bg-neutral-900 text-black dark:text-white">
<div id="loader" style="display: none">
    <img src="{{asset("assets/img/loader.svg")}}"/>
</div>
<nav class="bg-neutral-800 dark:bg-neutral-950">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="relative flex h-16 items-center justify-between">
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button id="menu-open" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open main menu</span>
                    <svg id="icon-menu-open" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <svg id="icon-menu-close" class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                <div class="flex flex-shrink-0 items-center">
                    <img class="h-8 w-auto" src="{{asset("assets/img/logo-white.png")}}" alt="MDevelopment">
                </div>
                <div class="hidden sm:ml-6 sm:block">
                    <div class="flex space-x-4">
                        <?php
                            $activeClass = "bg-neutral-600 dark:bg-neutral-800 text-white rounded-md px-3 py-2 text-sm font-medium";
                            $notActiveClass = "text-white rounded-md px-3 py-2 text-sm font-medium";
                        ?>
                        <a href="{{route("projects.index")}}" class="{{Route::currentRouteNamed('projects.*') ? $activeClass : $notActiveClass}}" aria-current="page">{{__("global.navbar.projects")}}</a>
                        <a href="{{route("billings.index")}}" class="{{Route::currentRouteNamed('billings.*') ? $activeClass : $notActiveClass}}" aria-current="page">{{__("global.navbar.billings")}}</a>
                        @if(\App\Http\Middleware\MyAuth::hasPermission(\App\PermissionEnum::SPECIAL_PERM__ALLOW_FOR_ADMIN, auth()->user()->role))
                            <form method="POST" action="{{route("application.change-company")}}">
                                @csrf
                                <select id="companies" name="company" onchange="this.form.submit()" class="cursor-pointer bg-gray-50 border p-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block">
                                    @foreach(session()->get("companies") as $company)
                                        <option {{session()->get("company")->id === $company->id ? "selected" : ""}} value="{{$company->id}}">{{$company->name}}</option>
                                    @endforeach
                                </select>
                                <noscript><input type="submit" value="Submit"></noscript>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                <button type="button" id="theme-mode" aria-haspopup="listbox" aria-expanded="true" data-headlessui-state="open active" aria-labelledby="headlessui-label-:R1lkcr6: headlessui-listbox-button-:R2lkcr6:" data-open="" data-active="" aria-controls="headlessui-listbox-options-:R3lkcr6:">
                    <span class="dark:hidden">
                        <i class='bx bx-sun text-white'></i>
                    </span>
                    <span class="hidden dark:inline">
                        <i class='bx bx-moon text-white'></i>
                    </span>
                </button>
                <div class="relative ml-3">
                    <div>
                        <button type="button" class="relative flex rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                            <span id="open-menu-span" class="absolute -inset-1.5"></span>
                            <span class="sr-only">Open user menu</span>
                            @if(session()->get("company")->file && session()->get("company")->file->unique_name)
                                <img class="h-8 w-8 rounded-full object-cover" src="{{route("files.show", session()->get("company")->file->unique_name)}}" alt="">
                            @else
                                <img class="h-8 w-8 rounded-full" src="{{asset("assets/img/default-user.jpg")}}" alt="">
                            @endif
                        </button>
                    </div>
                    <div id="profile-menu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                        <!-- Active: "bg-gray-100", Not Active: "" -->
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
                        <a href="{{route("auth.logout")}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">{{__("login.logout")}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="space-y-1 px-2 pb-3 pt-2">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-1">Settings</a>
            <a href="{{route("auth.logout")}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">{{__("login.logout")}}</a>
        </div>
    </div>
</nav>
<div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8 pt-5">
@yield("content")
</div>
<script>
    if (localStorage.getItem("dark-theme") === "true" || !localStorage.getItem("dark-theme")) {
        document.querySelector("html").classList.add("dark");
    } else {
        document.querySelector("html").classList.remove("dark");
    }
    let menu=document.getElementById('mobile-menu');
    menu.classList.toggle("hidden");
    document.addEventListener("click", function (e) {
        const id = e.target.getAttribute("id");
        if (!(id && (id.includes("open-menu-span") || id.includes("user-menu-item-")))) {
            document.getElementById("profile-menu").classList.add("hidden");
        }
        const dataMenuDropDown = e.target.getAttribute("data-menu-id");
        if (!dataMenuDropDown) {
            document.querySelectorAll("div[data-menu-id]:not(.hidden)").forEach(el => {
                el.classList.add("hidden");
            });
        }
    })
    document.getElementById("menu-open").addEventListener("click", function () {
        menu.classList.toggle("hidden");
        document.getElementById("icon-menu-open").classList.toggle("hidden");
        document.getElementById("icon-menu-close").classList.toggle("hidden");
    });
    document.getElementById("user-menu-button").addEventListener("click", function () {
        document.getElementById("profile-menu").classList.toggle("hidden");
    });
    document.getElementById("theme-mode").addEventListener("click", function () {
        document.querySelector("html").classList.toggle("dark");
        localStorage.setItem("dark-theme", document.querySelector("html").className.includes("dark"))
    })
    document.querySelectorAll("i[data-menu-id]").forEach(el => {
        el.addEventListener("click", function (e) {
            const id = e.target.getAttribute("data-menu-id");
            document.getElementById(id).classList.toggle("hidden");
        });
    })
</script>
</body>
</html>
