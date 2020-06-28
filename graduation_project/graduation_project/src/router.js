import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router);

export default new Router({
    routes: [
        {
            path: '/login',
            name: 'login',
            component: () => import(`@/views/AdminLogin`),
        },
        {
            path: '/Registered',
            name: 'Registered',
            component: () => import(`@/views/Registered`)
        },
        {
            path: '/content',
            name: 'content',
            component: () => import(`@/views/Content`),
        },
        {
            path: '/allNews',
            name: 'allNews',
            component: () => import(`@/views/AllNews`),
        },
        {
            path: '/Show',
            name: 'Show',
            component: () => import(`@/views/WebMessage/Show`),
        },
        {
            path: '/News',
            name: 'News',
            component: () => import(`@/views/WebMessage/News`),
        },
        {
            path: '/SchoolNews',
            name: 'SchoolNews',
            component: () => import(`@/views/WebMessage/SchoolNews`),
        },
        {
            path: '/Notice',
            name: 'Notice',
            component: () => import(`@/views/WebMessage/Notice`),
        },
        {
            path: '/About',
            name: 'About',
            component: () => import(`@/views/WebMessage/About`),
        },
        {
            path: '/Meeting',
            name: 'Meeting',
            component: () => import(`@/views/WebMessage/Meeting`),
        },
        {
            path: '/',
            redirect: '/Show'
        },
    ]
})
