
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="utf-8">
    <title>Connexion - MDevelopment</title>
    <meta name="viewport" content="width&#x3D;device-width,&#x20;initial-scale&#x3D;1.0">
    <meta http-equiv="X-UA-Compatible" content="IE&#x3D;edge">
    <!-- Le styles -->
    <link href='{{asset("assets/css/boxicons.min.css")}}' rel='stylesheet'>
    @vite('resources/css/app.css')
</head>

<body class="bg-white dark:bg-neutral-950">
<button id="theme-mode" type="submit" class="flex justify-center rounded-md bg-sky-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">Dark Mode</button>
<div id="loader" style="display: none">
    <img src="{{asset("assets/img/loader.svg")}}"/>
</div>
<script>
    function switchModeImgs() {
        const imgs = document.querySelectorAll("img[srcimg]");
        imgs.forEach(img => {
            const srcs = img.getAttribute('srcimg').split(", ");
            if (srcs.length === 1) {
                img.setAttribute("src", srcs[0]);
            } else if (srcs.length === 2) {
                // light theme
                const srcLight = srcs[0];
                // dark theme
                const srcDark = srcs[1];
                if (document.querySelector("html").className.includes("dark")) {
                    img.setAttribute("src", srcLight);
                } else {
                    img.setAttribute("src", srcDark);

                }
            }
        });
    }
    document.getElementById("theme-mode").addEventListener("click", function () {
        document.querySelector("html").classList.toggle("dark");
        switchModeImgs();
    })
    document.addEventListener("DOMContentLoaded", function(event) {
        switchModeImgs();
    });
</script>
<div>
@yield("content")
</div>
</body>
</html>
