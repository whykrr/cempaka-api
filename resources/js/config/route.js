import VueRouter from "vue-router";

// import Pages
import Home from "../pages/Home.vue";
import Content from "../pages/Content.vue";
import ContentList from "../pages/ContentList.vue";
import ContentForm from "../pages/ContentForm.vue";

const routes = new VueRouter({
    routes: [
        {
            path: "/",
            component: Home,
        },
        {
            path: "/home",
            redirect: "/",
        },
        /**
         * register route
         *
         * content route
         * content/form
         * content/:id
         */

        {
            path: "/content",
            component: Content,
            children: [
                {
                    path: "",
                    component: ContentList,
                },
                {
                    path: "form",
                    component: ContentForm,
                },
            ],
        },
    ],
    mode: "history",
});

export default routes;
