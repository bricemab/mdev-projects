@extends("layouts.nolayout")

@section("content")
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-28 sm:h-auto w-auto sm:w-80" srcimg="{{asset("assets/img/logo_300x300.png")}}, {{asset("assets/img/logo_black_300x300.png")}}" alt="MDevelopment">
        </div>

        <div class="mt-5 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" action="{{route("auth.login")}}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 dark:text-gray-100 text-gray-900">{{__("login.email")}}</label>
                    <div class="mt-2">
                        <input id="email" tabindex="1" name="email" type="text" autocomplete="email" value="{{old("email", "bricemabi@gmail.com")}}" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="text-red-700 dark:text-red-500">
                        @error("email")
                        {{$message}}
                        @enderror
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium leading-6 dark:text-gray-100 text-gray-900">{{__("login.password")}}</label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-sky-600 hover:text-sky-500">{{__("login.forgotPassword")}}</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input id="password" tabindex="2" name="password" type="password" autocomplete="current-password" value="{{old("password", "admin")}}" required class="p-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
                    </div>
                    <div class="text-red-700 dark:text-red-500">
                        @error("password")
                        {{$message}}
                        @enderror
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-sky-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">{{__("login.connect")}}</button>
                </div>
            </form>
        </div>
    </div>
{{--    <div class="text-center p-5" id="email-form">--}}
{{--        <img src="{{asset("assets/img/logo_400x400.png")}}" title="Logo MDevelopment">--}}
{{--        <p class="h5 mb-4"></p>--}}

{{--        <div class="email" id="id-form">--}}
{{--            <input type="text" name="email" id="email" class="form-control mb-4"--}}
{{--                   placeholder="Nom d'utilisateur" required autofocus><br>--}}
{{--            <input type="password" name="password" id="password" class="form-control mb-4"--}}
{{--                   placeholder="Mot de passe" required><br>--}}
{{--            <button id="submit" class="form-control btn btn-primary"--}}
{{--                    style="max-width: 400px;">{{__("login.connect")}}</button>--}}
{{--        </div>--}}
{{--        <div class="digit-code" id="two-fa-form" style="display: none">--}}
{{--            <input id="digit-code" type="number" autofocus="autofocus"--}}
{{--                   aria-label="Enter the code generated by your authentication app" class="form-masked-pin">--}}
{{--            <div class="bg-box-group">--}}
{{--                <div class="bg-box"></div>--}}
{{--                <div class="bg-box"></div>--}}
{{--                <div class="bg-box"></div>--}}
{{--                <div class="bg-box"></div>--}}
{{--                <div class="bg-box"></div>--}}
{{--                <div class="bg-box"></div>--}}
{{--            </div>--}}
{{--            <br>--}}
{{--            <div>Entrer le code sur l'application<b> Google Authenticator</b></div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <script>
        const codeInput = document.getElementById('digit-code');
        codeInput.addEventListener('keyup', () => {
            codeInput.value = codeInput.value.slice(0, 6);
            let i = 0;
            let code = "";
            codeInput.value.split("").map(letter => {
                if (!isNaN(letter) && i < 6) {
                    code += letter;
                }
                i++;
            });
            codeInput.value = code;
            if (code.length === 6 && !isNaN(code)) {
                codeInput.setAttribute('disabled', "disabled")
                showLoader();
                email();
            }
        });

        document.getElementById('submit').addEventListener('click', () => {
            $("#id-form").hide();
            $("#two-fa-form").show();
        });

        function email() {
            jQuery.ajax({
                type: "POST",
                url: "/email",
                data: {
                    email: jQuery('#email').val(),
                    password: jQuery('#password').val(),
                    code: $("#digit-code").val()
                },
                success: function (data) {
                    if (data.success) {
                        location.href = "";
                    } else {
                        iziToastWarning(data.error.message);
                        codeInput.removeAttribute("disabled")
                        $("#email").val("");
                        $("#password").val("");
                        $("#digit-code").val("");
                        $("#id-form").show();
                        $("#two-fa-form").hide();
                    }
                    hideLoader();
                }
            });
        }
    </script>
@endsection
