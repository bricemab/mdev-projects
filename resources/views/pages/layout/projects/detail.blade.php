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
            <div class="w-10/12 m-auto">
                <canvas id="chart"></canvas>
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
    <script>
        const project = @json($project);
        const tasks = @json($project->tasks);
        const taskNames = [];
        const hours = []
        const progressHours = []
        taskNames.push(project.name);
        hours.push(project.hours);
        let progressProjectHours = 0;
        tasks.map(task => {
            progressProjectHours += MdevUtils.convertHoursMinutesToDecimal(task.progress_hours);
            taskNames.push(task.name);
            hours.push(MdevUtils.convertHoursMinutesToDecimal(task.hours));
            progressHours.push(MdevUtils.convertHoursMinutesToDecimal(task.progress_hours));
        });
        progressHours.unshift(progressProjectHours);

        const TYPE_PROGRESS_HOURS = "TYPE_PROGRESS_HOURS";
        const TYPE_CURRENT_HOURS = "TYPE_CURRENT_HOURS";
        var ctx = document.getElementById('chart').getContext('2d');
        const progressChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: taskNames,
                datasets: [
                    {
                        label: '',
                        data: hours,
                        tasks,
                        columnType: TYPE_CURRENT_HOURS,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: '',
                        data: progressHours,
                        tasks,
                        columnType: TYPE_PROGRESS_HOURS,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: "{{__('projects.detail.Hours')}}"
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: "{{__('projects.detail.tasks')}}"
                        },
                        ticks: {
                            display: false
                        },
                        stacked: false
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                let task = tasks[context.dataIndex-1];
                                if (!task) {
                                    task = {
                                        hours: MdevUtils.convertDecimalToHoursMinutes(project.hours),
                                        progress_hours: MdevUtils.convertDecimalToHoursMinutes(progressProjectHours)
                                    }
                                }
                                const hoursProgress = task.progress_hours;
                                const subtract = MdevUtils.convertHoursMinutesToDecimal(task.hours) - MdevUtils.convertHoursMinutesToDecimal(task.progress_hours);
                                let hoursRemained = MdevUtils.convertDecimalToHoursMinutes(subtract);
                                if (subtract < 0) {
                                    hoursRemained = "-"+MdevUtils.convertDecimalToHoursMinutes(MdevUtils.convertHoursMinutesToDecimal(task.progress_hours) - MdevUtils.convertHoursMinutesToDecimal(task.hours));
                                }
                                const hours = task.hours;
                                if (context.dataset.columnType === TYPE_CURRENT_HOURS) {
                                    return [
                                        `{{__('projects.detail.remained')}}: ${hoursRemained} {{__('projects.detail.hours')}}`,
                                        `Heures totales: ${hours} {{__('projects.detail.hours')}}`,
                                    ]
                                }
                                return [
                                    `Heures restantes: ${hoursRemained} {{__('projects.detail.hours')}}`,
                                    `Heures effectuées: ${hoursProgress} {{__('projects.detail.hours')}}`,
                                ];
                            }
                        }
                    }
                },
                onClick: function(event, elements) {
                    if (elements.length > 0) {
                        const elementIndex = elements[0].index;
                        const task = tasks[elementIndex-1];
                        if (!task) {
                            return alert("Il n'y a pas de détail disponible pour le projet. Veuillez cliquer sur une tâche")
                        }
                        alert(`Tâche: ${task.name}\nHeures prévues: ${task.hours}\nHeures réelles: ${task.progress_hours}\nHeures restantes: ${MdevUtils.convertDecimalToHoursMinutes(MdevUtils.convertHoursMinutesToDecimal(task.hours) - MdevUtils.convertHoursMinutesToDecimal(task.progress_hours))}`);
                    }
                }
            }
        });
    </script>
@endsection
