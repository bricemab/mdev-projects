class MdevUtils {
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
}
