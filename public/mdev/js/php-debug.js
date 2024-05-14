$.ajaxSetup({
    dataFilter: function (response, type) {
        if (response && response.includes("<script id='php-debugger'")) {
            const [data, debug] = response.split("<script id='php-debugger' data-logged='[", 2);
            response = data;

            const logs = JSON.parse("[" + debug.split("]'>")[0] + "]");
            if (logs.length !== 0) {
                logs.forEach(log => console.log(log));

                if (logs.length === 1 && String(logs[0]).length < 100)
                    alert(logs[0]);
                else
                    alert("Some elements have been logged to console !\rDon't close this popup if a redirection is done next and you want to see the console before !");
            }
        }

        return response;
    }
});