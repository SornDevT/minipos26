import { createWebHistory, createRouter } from "vue-router";

import Store from "../Pages/Store.vue";
import Category from "../Pages/Category.vue";
import Pos from "../Pages/Pos.vue";
import Transection from "../Pages/Transection.vue";
import Report from "../Pages/Report.vue";
import NoPath from "../Pages/NoPath.vue";
import Login from "../Pages/Login.vue";

import { useAuthStore } from "../Stores/Auth.js";

const isAuthenticated = () => {
    const authStore = useAuthStore();
    return authStore.isAuthenticated;
}

const routes = [
    {
        path: "/login",
        name: "Login",
        component: Login
    },
    {
        path: "/",
        redirect: "/store"
    },
    {
        path: "/store",
        name: "Store",
        component: Store,
        meta: { isAuthenticated: true }
    },
    {
        path: "/category",
        name: "Category",
        component: Category,
        meta: { isAuthenticated: true }
    },
    {
        path: "/pos",
        name: "Pos",
        component: Pos,
        meta: { isAuthenticated: true }
    },
    {
        path: "/transection",
        name: "Transection",
        component: Transection,
        meta: { isAuthenticated: true }
    },
    {
        path: "/report",
        name: "Report",
        component: Report,
        meta: { isAuthenticated: true }
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


// Navigation Guard
router.beforeEach((to, from, next) => {
    if (to.meta.isAuthenticated && !isAuthenticated()) {
        next({ name: "Login" });
    } else if (to.name === "Login" && isAuthenticated()) {
        next({ name: "Store" });
    }  else {
        next();
    }
});

export default router;