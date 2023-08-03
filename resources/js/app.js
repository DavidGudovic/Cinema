import "./bootstrap";
import "../css/app.css";
import Alpine from "alpinejs";
import "@fortawesome/fontawesome-free/css/all.css";
import intersect from "@alpinejs/intersect";
import focus from "@alpinejs/focus";
import "./carousel.js";

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(intersect);
Alpine.start();
