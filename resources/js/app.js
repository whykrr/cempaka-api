/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

// import all conig
import VueRouter from "vue-router";
import router from "./config/route";

const componentPath = "./components";

// App Layout
Vue.component(
    "app-header",
    require(componentPath + "/layout/Header.vue").default
);
Vue.component(
    "app-footer",
    require(componentPath + "/layout/Footer.vue").default
);

// Use Router with Vue
Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    linkActiveClass: "active",
    el: "#app",
    router,
});
