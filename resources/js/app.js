import "./bootstrap";
import "../css/app.css";
import Alpine from "alpinejs";
import "@fortawesome/fontawesome-free/css/all.css";
import intersect from "@alpinejs/intersect";
import focus from "@alpinejs/focus";
import breakpoint from "alpinejs-breakpoints";

window.Alpine = Alpine;

Alpine.plugin(breakpoint);
Alpine.plugin(focus);
Alpine.plugin(intersect);
Alpine.start();
