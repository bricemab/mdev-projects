@extends("layouts.layout")

@section("content")
    <div class="relative sm:rounded-lg flex gap-5">
        <a href="{{url()->previous()}}" class="hidden sm:flex sm:text-center text-neutral-700 max-w-max align-items-center justify-content-center bg-neutral-50 hover:bg-neutral-200 cursor-pointer dark:bg-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-800 font-bold p-2 rounded">
            <i class='bx bx-chevron-left text-[25px]'></i>
            {{__("global.back")}}
        </a>
        <div class="flex-1 items-center content-center text-2xl font-bold">{{$project->name}}</div>
    </div>
    <div class="grid grid-cols-3 my-5 h-1">
        <div class="col-span-2">
            <div class="text-xl font-bold my-2 mx-5 border-b px-4 py-2">
                {{__("projects.detail.view-pool-hours")}}
            </div>
        </div>
        <div>
            <div class="text-xl font-bold my-2 mx-5 border-b px-4 py-2">{{__("projects.detail.information")}}</div>
            <ul class="mx-10">
                <li>
                    <i class='bx bxs-user'></i>
                    <span class="font-bold">{{__("projects.detail.client")}}:</span>
                    <span>{{$project->company->name}}</span>
                </li>
                <li>
                    <i class='bx bxs-calendar' ></i>
                    <span class="font-bold">{{__("projects.headers.dates")}}:</span>
                    <span>{{date("d.m.Y", strtotime($project->start_date))}} - {{date("d.m.Y", strtotime($project->end_date))}}</span>
                </li>
                <li>
                    <i class='bx bxs-file'></i>
                    <span class="font-bold">{{__("projects.detail.project-contract")}}:</span>
                    <span>{{$project->name}}</span>
                </li>
                <li>
                    <i class='bx bxs-objects-horizontal-left' ></i>
                    <span class="font-bold">{{__("projects.detail.pool")}}:</span>
                    <span>{{$project->hours }}</span>
                </li>
            </ul>
        </div>
    </div>
@endsection
