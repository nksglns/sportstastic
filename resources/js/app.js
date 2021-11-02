require("./bootstrap");

import Vue from "vue";

import VueRouter from "vue-router";
Vue.use(VueRouter);

import App from "./components/frontend/App";
import Sports from "./components/frontend/Sports";
import Leagues from "./components/frontend/Leagues";
import Teams from "./components/frontend/Teams";
import Team from "./components/frontend/Team";

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "sports",
            component: Sports,
        },
        {
            path: "/:sportSlug",
            name: "leagues",
            component: Leagues,
        },
        {
            path: "/:sportSlug/:leagueSlug",
            name: "teams",
            component: Teams,
        },
        {
            path: "/:sportSlug/:leagueSlug/:teamSlug",
            name: "team",
            component: Team,
        },
    ],
});

router.beforeEach((to, from, next) => {
    NProgress.start();
    NProgress.set(0.1);
    next();
});

const app = new Vue({
    el: "#app",
    components: { App },
    router,
});
