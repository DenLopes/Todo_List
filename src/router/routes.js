const routes = [
  {
    path: "/",
    redirect: "/main",
    component: () => import("layouts/MainLayout.vue"),
    children: [
      { path: "/main", component: () => import("pages/MainPage.vue") },
      { path: "/recent", component: () => import("pages/RecentPage.vue") },
      {
        path: "/task/:id",
        component: () => import("pages/TaskPage.vue"),
        props: true,
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
