import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();


class LiveDateTime {
    constructor() {
        this.timeElement = document.getElementById("live-clock");
        this.dateElement = document.getElementById("live-date");
        this.start();
    }

    update() {
        const now = new Date();

        // Time formatting
        const time = now.toLocaleTimeString("en-US", {
            hour: "numeric",
            minute: "2-digit",
            second: "2-digit",
            hour12: true,
        });

        // Date formatting
        const date = now.toLocaleDateString("en-US", {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        });

        this.timeElement.textContent = time;
        this.dateElement.textContent = date;
    }

    start() {
        this.update();
        setInterval(() => this.update(), 1000);
    }
}

// Initialize when document is loaded
document.addEventListener("DOMContentLoaded", () => {
    new LiveDateTime();
});
