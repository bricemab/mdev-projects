@extends("layouts.layout")

@section("content")
    <div id="add-task" class="mx-auto">
        @csrf
        <p class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.add-project")}}</p>
        <div class="grid md:grid-cols-5 md:gap-6">
            <div class="relative z-0 w-full mb-5 group col-span-2">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.name")}}</label>
                <input type="text" id="name" name="name" placeholder="{{__("projects.add-modal.name")}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="url-prod" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.url-prod")}}</label>
                <input type="url" id="url-prod" name="url-prod" placeholder="https://mdevelopment.ch/" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black"/>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="url-preprod" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.url-preprod")}}</label>
                <input type="text" id="url-preprod" name="url-preprod" placeholder="https://mdevelopment.ch/" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black"/>
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="github" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.headers.github")}}</label>
                <input type="text" id="github" name="github" placeholder="https://github.com/bricemab/mdev-project.git" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black"/>
            </div>
        </div>
        <div class="grid md:grid-cols-3 md:gap-6">
            <div class="relative z-0 w-full mb-5 group">
                <label for="rate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.rate")}}</label>
                <input type="number" min="0" value="65" id="rate" name="rate" placeholder="{{__("projects.add-modal.rate")}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="hours" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.hours")}}</label>
                <input type="number" min="0" disabled step="0.5" id="hours" name="hours" placeholder="{{__("projects.add-modal.hours")}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black" />
            </div>
            <div class="relative z-0 w-full mb-5 group">
                <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.price")}}</label>
                <input type="number" disabled value="0" id="price" placeholder="{{__("projects.add-modal.price")}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black" />
            </div>
        </div>
        <div class="w-full">
            <label for="cdc-file" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.cdc")}}</label>
            <label for="cdc-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-neutral-200 dark:bg-neutral-50 hover:bg-neutral-100 dark:border-neutral-600 dark:hover:border-gray-500">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    <p id="label-input" class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">{{__("projects.add-modal.click-upload")}}</span> {{__("projects.add-modal.or-drag-drop")}}</p>
                    <p id="label-input-selected" class="hidden mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold"></span></p>
                </div>
                <input id="cdc-file" type="file" name="cdc-file" class="hidden" accept="application/pdf" />
            </label>
        </div>
        <div class="w-full my-5">
            <p class="block mb-2 text-lg font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.add-tasks")}}</p>
            <div class="grid md:grid-cols-12 md:gap-6">
                <div class="min-w-full col-span-1 flex justify-end items-center">
                </div>
                <div class="relative z-0 w-full group col-span-3">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.name")}}</label>
                </div>
                <div class="relative w-full group col-span-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.description")}}</label>
                </div>
                <div class="relative w-full group col-span-2">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{__("projects.add-modal.hours")}}</label>
                </div>
            </div>
            <div id="add-tasks-container"></div>
        </div>
        <button onclick="save()" class="float-right my-5 sm:flex sm:text-center text-neutral-700 max-w-max align-items-center justify-content-center bg-neutral-50 hover:bg-neutral-200 cursor-pointer dark:bg-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-800 font-bold p-2 rounded">{{__("projects.save")}}</button>
    </div>
    <script>
        const addTaskContainer = document.getElementById("add-tasks-container");
        newTaskElement(MdevUtils.randomId(10));
        document.getElementById("cdc-file").addEventListener("change", e => {
            if (e.target.files.length === 1) {
                document.getElementById("label-input").classList.add("hidden");
                document.getElementById("label-input-selected").classList.remove("hidden");
                document.querySelector("#label-input-selected span").innerHTML = e.target.files[0].name
            } else {
                document.getElementById("label-input").classList.remove("hidden");
                document.getElementById("label-input-selected").classList.add("hidden");
            }
        })
        document.querySelectorAll("#rate, #hours").forEach(element => {
            element.addEventListener("change", e => {
                let value = 1;
                document.querySelectorAll("#rate, #hours").forEach(el => {
                    value *= parseFloat(el.value);
                });
                document.getElementById("price").value = value;
            })
        });
        function newTaskElement(id) {
            document.querySelectorAll("#add-tasks-container .bx-plus").forEach(el => {
                el.classList.add("hidden")
            });
            const taskContainer = document.createElement('div');
            taskContainer.id = id;
            taskContainer.className = 'mb-5 grid md:grid-cols-12 md:gap-6';

            const plusIconContainer = document.createElement('div');
            plusIconContainer.className = 'min-w-full col-span-1 flex justify-end items-center';
            const plusIcon = document.createElement('i');
            plusIcon.className = 'bx bx-plus font-bold text-2xl cursor-pointer';
            plusIcon.addEventListener("click", () => {
                newTaskElement(MdevUtils.randomId(10));
            })
            plusIconContainer.appendChild(plusIcon);

            const taskNameContainer = document.createElement('div');
            taskNameContainer.className = 'relative z-0 w-full group col-span-3';
            const taskNameInput = document.createElement('input');
            taskNameInput.type = 'text';
            taskNameInput.id = 'task-name-'+id;
            taskNameInput.placeholder = '{{__("projects.add-modal.name")}}';
            taskNameInput.className = 'task-name bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black';
            taskNameContainer.appendChild(taskNameInput);

            const taskDescContainer = document.createElement('div');
            taskDescContainer.className = 'relative w-full group col-span-6';
            const taskDescInput = document.createElement('input');
            taskDescInput.type = 'text';
            taskDescInput.id = 'task-description-'+id;
            taskDescInput.placeholder = '{{__("projects.add-modal.description")}}';
            taskDescInput.className = 'task-description bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black';
            taskDescContainer.appendChild(taskDescInput);

            const taskHoursContainer = document.createElement('div');
            taskHoursContainer.className = 'relative w-full group col-span-2';
            const taskHoursInput = document.createElement('input');
            taskHoursInput.type = 'text';
            taskHoursInput.id = 'task-hours-'+id;
            taskHoursInput.placeholder = '{{__("projects.add-modal.hours")}}';
            taskHoursInput.className = 'task-description bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-neutral-50 dark:border-gray-600 dark:text-black';
            taskHoursContainer.appendChild(taskHoursInput);

            const trashIconContainer = document.createElement('div');
            trashIconContainer.className = 'min-w-full col-span-1 flex justify-start items-center';
            const trashIcon = document.createElement('i');
            trashIcon.className = 'bx bx-trash font-bold text-2xl cursor-pointer';
            trashIcon.addEventListener("click", () => {
                if (document.querySelectorAll("#add-tasks-container .bx-plus").length > 1) {
                    document.getElementById(id).remove();
                    const bxPlusIcons = document.querySelectorAll("#add-tasks-container .bx-plus");
                    bxPlusIcons.forEach(el => {
                        el.classList.add("hidden")
                    });
                    bxPlusIcons[bxPlusIcons.length - 1].classList.remove("hidden");
                }
            })
            trashIconContainer.appendChild(trashIcon);
            taskContainer.appendChild(plusIconContainer);
            taskContainer.appendChild(taskNameContainer);
            taskContainer.appendChild(taskDescContainer);
            taskContainer.appendChild(taskHoursInput);
            taskContainer.appendChild(trashIconContainer);

            document.getElementById('add-tasks-container').appendChild(taskContainer);
        }
        function save() {
            const name = document.getElementById("name").value;
            const urlProd = document.getElementById("url-prod").value;
            const urlPreprod = document.getElementById("url-preprod").value;
            const github = document.getElementById("github").value;
            const rate = document.getElementById("rate").value;
            const fileCdc = document.getElementById("cdc-file");
            const file = fileCdc.files[0];

            // Create a FormData object
            const formData = new FormData();
            formData.append('name', name);
            formData.append('url_prod', urlProd);
            formData.append('url_preprod', urlPreprod);
            formData.append('github', github);
            formData.append('rate', rate);
            if (file) {
                formData.append('cdc_file', file);
            }
            document.querySelectorAll("#add-tasks-container > div").forEach((div, i) => {
                const id = div.getAttribute("id");
                const taskName = document.getElementById("task-name-"+id).value.trim();
                const taskDescription = document.getElementById("task-description-"+id).value.trim();
                const taskHours = document.getElementById("task-hours-"+id).value.trim();
                if (taskName !== "" && taskDescription !== "" && taskHours !== "") {
                    formData.append(`tasks[${i}][name]`, taskName);
                    formData.append(`tasks[${i}][description]`, taskDescription);
                    formData.append(`tasks[${i}][hours]`, taskHours);
                }
            });
            MdevUtils.axiosPost('{{route("projects.add-action")}}', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {

            }).catch(error => {
                console.log(error)
                for (const [key, err] of Object.entries(error.errors)) {
                    err.forEach(e => {
                        MdevUtils.errorAlert(e, 3000);
                    })
                }
            })
        }
    </script>
@endsection
