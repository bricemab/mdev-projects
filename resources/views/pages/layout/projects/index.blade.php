@extends("layouts.layout")

@section("content")

    <div class="relative sm:rounded-lg">
        @if(\App\Http\Middleware\MyAuth::hasPermission(\App\PermissionEnum::PROJECTS__ADD, auth()->user()->role))
            <div class="relative sm:rounded-lg flex gap-5 my-5 float-right">
                <a href="{{route("projects.add")}}" class="hidden sm:flex sm:text-center text-neutral-700 max-w-max align-items-center justify-content-center bg-neutral-50 hover:bg-neutral-200 cursor-pointer dark:bg-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-800 font-bold p-2 rounded">
                    <i class='bx bx-plus text-[25px]'></i>
                    {{__("projects.add")}}
                </a>
            </div>
        @endif
        <table class="w-full text-sm text-left rtl:text-right text-neutral-500 dark:text-neutral-400">
            <thead class="text-xs text-neutral-700 uppercase bg-neutral-50 dark:bg-neutral-700 dark:text-neutral-400">
            <tr>
                <th scope="col" class="px-6 py-3">{{__("projects.headers.projects")}}</th>
                <th scope="col" class="px-6 py-3 text-center">{{__("projects.headers.hours")}}</th>
                <th scope="col" class="px-6 py-3 text-center">{{__("projects.headers.rate")}}</th>
                <th scope="col" class="px-6 py-3 text-center">{{__("projects.headers.price")}}</th>
                <th scope="col" class="px-6 py-3 text-center">{{__("projects.headers.state")}}</th>
                <th scope="col" class="px-6 py-3 text-center">{{__("projects.headers.links")}}</th>
                <th scope="col" class="px-6 py-3 text-center">{{__("projects.headers.dates")}}</th>
                <th scope="col" class="px-6 py-3 text-center">{{__("projects.headers.cdc")}}</th>
                <th scope="col" class="px-6 py-3"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr class="bg-white border-b dark:bg-neutral-800 dark:border-neutral-700">
                    <?php $rdmId = \Illuminate\Support\Str::random(10) ?>
                    <th scope="row" class="px-6 py-4 font-medium text-neutral-900 whitespace-nowrap dark:text-white">
                        {{$project->name}}
                    </th>
                    <td class="px-6 py-4 text-center">
                        {{$project->hours}}
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{$project->rate}}.-
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{$project->price}}.-
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{\App\ProjectStateEnum::getLabel($project->state)}}
                    </td>
                    <td class="px-6 py-4">
                        @if($project->url_prod)
                            <a class="hover:text-sky-600" href="{{$project->url_prod}}"
                               target="_blank">{{$project->url_prod}}</a>
                        @endif
                        @if($project->url_preprod)
                            <a class="hover:text-sky-600" href="{{$project->url_preprod}}"
                               target="_blank">{{$project->url_preprod}}</a>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        {{date("d.m.Y", strtotime($project->start_date))}}
                        <br>{{date("d.m.Y", strtotime($project->end_date))}}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{route("files.download", $project->file->unique_name)}}">
                            <i class='bx bxs-file-pdf cursor-pointer text-xl'></i>
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <i data-menu-id="{{$rdmId}}" class='px-1.5 py-1.5 text-neutral-400 cursor-pointer bx bx-dots-vertical-rounded'></i>
                        </div>
                        <div
                            id="{{$rdmId}}"
                            data-menu-id="{{$rdmId}}"
                            class="bg-neutral-50 dark:bg-neutral-700 hidden absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                            <div class="py-1" role="none">
                                <a href="{{route("projects.detail", $project->id)}}" class="text-neutral-400 block px-4 py-2 text-sm hover:text-neutral-500" role="menuitem" tabindex="-1"
                                   id="menu-item-0">{{__("projects.details")}}</a>
                                @if(\App\Http\Middleware\MyAuth::hasPermission(\App\PermissionEnum::PROJECTS__EDIT, auth()->user()->role))
                                    <a href="{{route("projects.detail", $project->id)}}" class="text-neutral-400 block px-4 py-2 text-sm hover:text-neutral-500" role="menuitem" tabindex="-1"
                                       id="menu-item-1">{{__("projects.edit")}}</a>
                                @endif
                                @if(\App\Http\Middleware\MyAuth::hasPermission(\App\PermissionEnum::PROJECTS__DELETE, auth()->user()->role))
                                    <a href="{{route("projects.detail", $project->id)}}" class="text-neutral-400 block px-4 py-2 text-sm hover:text-neutral-500" role="menuitem" tabindex="-1"
                                       id="menu-item-2">{{__("projects.delete")}}</a>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
