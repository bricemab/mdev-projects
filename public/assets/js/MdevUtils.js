class MdevUtils {
    static axiosPost(url, data, config) {
        return new Promise((resolve, reject) => {
            axios.post(url, data, config).then(res => {
                resolve(res.data);
            }).catch(res => {
                if (res.response.data && res.response.data.success === false) {
                    reject(res.response.data);
                } else {
                    reject(res.response)
                }
            });
        })
    }
    static randomId(length = 20) {
        const chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghiklmnopqrstuvwxyz'.split('');
        if (!length)
            length = Math.floor(Math.random() * chars.length);
        let str = '';
        for (let i = 0; i < length; i++)
            str += chars[Math.floor(Math.random() * chars.length)];
        return str;
    }
    static convertHoursMinutesToDecimal(hoursMinutes) {
        let [hours, minutes] = hoursMinutes.split(':').map(Number);
        let decimalMinutes = minutes / 60;
        return hours + decimalMinutes;
    }

    static convertDecimalToHoursMinutes(decimalHours) {
        let hours = Math.floor(decimalHours);
        let decimalPart = decimalHours - hours;
        let minutes = Math.round(decimalPart * 60);
        return `${hours}:${minutes.toString().padStart(2, '0')}`;
    }

    static successAlert(txt, timeout = 3000) {
        const alert = document.createElement('div');
        alert.className = 'fixed top-12 left-1/2 transform -translate-x-1/2 p-3 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 rounded shadow-lg';
        const icon = document.createElement('i');
        icon.className = 'bx bxs-check-circle mr-2';
        alert.appendChild(icon);
        const text = document.createElement('span');
        text.textContent = txt;
        alert.appendChild(text);
        document.body.appendChild(alert);
        setTimeout(() => {
            document.body.removeChild(alert);
        }, timeout);
    }
    static errorAlert(txt, timeout = 3000) {
        let alertContainer = document.getElementById('alert-container');

        // Create the alert container if it doesn't exist
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.id = 'alert-container';
            alertContainer.className = 'fixed top-12 left-1/2 transform -translate-x-1/2 space-y-2';
            document.body.appendChild(alertContainer);
        }

        // Create the alert
        const alert = document.createElement('div');
        alert.className = 'p-3 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300 rounded shadow-lg flex items-center';
        const icon = document.createElement('i');
        icon.className = 'bx bxs-error mr-2';
        alert.appendChild(icon);
        const text = document.createElement('span');
        text.textContent = txt;
        alert.appendChild(text);
        alertContainer.appendChild(alert);

        // Remove the alert after the timeout
        setTimeout(() => {
            alertContainer.removeChild(alert);
            // Remove the container if no alerts are present
            if (alertContainer.children.length === 0) {
                document.body.removeChild(alertContainer);
            }
        }, timeout);
    }
}
