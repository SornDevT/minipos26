import { createWebHistory, createRouter } from "vue-router";

import Store from "../Pages/Store.vue";
import Category from "../Pages/Category.vue";
import Pos from "../Pages/Pos.vue";
import Transection from "../Pages/Transection.vue";
import Report from "../Pages/Report.vue";
import NoPath from "../Pages/NoPath.vue";

const routes = [
    {
        path: "/",
        redirect: "/store"
    },
    {
        path: "/store",
        name: "Store",
        component: Store
    },
    {
        path: "/category",
        name: "Category",
        component: Category
    },
    {
        path: "/pos",
        name: "Pos",
        component: Pos
    },
    {
        path: "/transection",
        name: "Transection",
        component: Transection
    },
    {
        path: "/report",
        name: "Report",
        component: Report
    },
    {
        path: "/:pathMatch(.*)*",
        name: "NoPath",
        component: NoPath
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
    scrollBehavior() {
        window.scrollTo(0, 0);
    }
});

export default router;