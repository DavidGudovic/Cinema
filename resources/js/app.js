import "./bootstrap";
import "../css/app.css";
import Alpine from "alpinejs";
import "@fortawesome/fontawesome-free/css/all.css";
import intersect from "@alpinejs/intersect";

window.Alpine = Alpine;

Alpine.plugin(intersect);
Alpine.start();
