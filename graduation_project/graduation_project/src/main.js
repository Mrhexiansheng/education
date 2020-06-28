import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import ElementUI from 'element-ui';
import md5 from 'md5'
import 'element-ui/lib/theme-chalk/index.css';
import VueAwesomeSwiper from 'vue-awesome-swiper'
import 'swiper/dist/css/swiper.css'
// fade/zoom 等
import 'element-ui/lib/theme-chalk/base.css';
// collapse 展开折叠
import CollapseTransition from 'element-ui/lib/transitions/collapse-transition';

//引入请求
import axios from "./api/methods";
//引入api
import api from "./api/api"

Vue.config.productionTip = false;

Vue.prototype.$axios = axios;

Vue.prototype.$api = api;

Vue.prototype.$md5 = md5;

Vue.component(CollapseTransition.name, CollapseTransition);

//超级管理员
let route = [{
    path: "/main",
    name: "AdminMain",
    component: () => import( "./views/AdminMain"),
    children: [
        {
            path: "admin",
            name: "Admin",
            component: () => import("./views/Admin/Admin"),
            meta: {
                title: "个人中心"
            },
            children: [
                {
                    path: "RootInformation",
                    name: "RootInformation",
                    component: () => import("./views/Admin/RootInformation"),
                    meta: {
                        title: "资料修改"
                    },
                },
            ],
        },
        {
            path: "Personnel",
            name: "Personnel",
            component: () => import("./views/Personnel/Personnel"),
            meta: {
                title: "人事管理"
            },
            children: [
                {
                    path: "UserShow",
                    name: "UserShow",
                    component: () => import("./views/Personnel/UserShow"),
                    meta: {
                        title: "用户管理"
                    },
                },
                {
                    path: "DepartmentManage",
                    name: "DepartmentManage",
                    component: () => import("./views/Personnel/DepartmentManage"),
                    meta: {
                        title: "部门管理"
                    },
                }
            ],
        },
        {
            path: "Project",
            name: "Project",
            component: () => import("./views/Project/Project"),
            meta: {
                title: "项目管理"
            },
            children: [
                {
                    path: "AdminManage",
                    name: "AdminManage",
                    component: () => import("./views/Project/AdminManage"),
                    meta: {
                        title: "立项管理"
                    },
                },
                {
                    path: "ProjectLibrary",
                    name: "ProjectLibrary",
                    component: () => import("./views/Project/ProjectLibrary"),
                    meta: {
                        title: "项目库管理"
                    },
                },
            ],
        },
        {
            path: "Message",
            name: "Message",
            component: () => import("./views/Message/Message"),
            meta: {
                title: "前台信息管理"
            },
            children: [
                {
                    path: "NavigationManagement",
                    name: "NavigationManagement",
                    component: () => import("./views/Message/NavigationManagement"),
                    meta: {
                        title: "导航管理"
                    },
                },
                {
                    path: "NewsManage",
                    name: "NewsManage",
                    component: () => import("./views/Message/NewsManage"),
                    meta: {
                        title: "新闻资讯管理"
                    },
                },
                {
                    path: "SchoolInformation",
                    name: "SchoolInformation",
                    component: () => import("./views/Message/SchoolInformation"),
                    meta: {
                        title: "校内资讯管理"
                    },
                },
                {
                    path: "Notifications",
                    name: "Notifications",
                    component: () => import("./views/Message/Notifications"),
                    meta: {
                        title: "信息通知管理"
                    },
                },
                {
                    path: "MeetingManage",
                    name: "MeetingManage",
                    component: () => import("./views/Message/MeetingManage"),
                    meta: {
                        title: "会议活动信息管理"
                    },
                },
            ],
        },
    ]
}];


//领导权限
let route2 = [{
    path: "/main",
    name: "AdminMain",
    component: () => import( "./views/AdminMain"),
    children: [
        {
            path: "admin",
            name: "Admin",
            component: () => import("./views/Admin/Admin"),
            meta: {
                title: "个人中心"
            },
            children: [
                {
                    path: "ChangeInformation",
                    name: "ChangeInformation",
                    component: () => import("./views/Admin/ChangeInformation"),
                    meta: {
                        title: "资料修改"
                    },
                },
            ],
        },
        {
            path: "Project",
            name: "Project",
            component: () => import("./views/Project/Project"),
            meta: {
                title: "项目管理"
            },
            children: [
                {
                    path: "LeaderManage",
                    name: "LeaderManage",
                    component: () => import("./views/Project/LeaderManage"),
                    meta: {
                        title: "立项管理"
                    },
                },
                {
                    path: "ProjectLibrary",
                    name: "ProjectLibrary",
                    component: () => import("./views/Project/ProjectLibrary"),
                    meta: {
                        title: "项目库管理"
                    },
                },
            ],
        },
    ]
}];

//专家权限
let route3 = [{
    path: "/main",
    name: "AdminMain",
    component: () => import( "./views/AdminMain"),
    children: [
        {
            path: "admin",
            name: "Admin",
            component: () => import("./views/Admin/Admin"),
            meta: {
                title: "个人中心"
            },
            children: [
                {
                    path: "ExpertsInformation",
                    name: "ExpertsInformation",
                    component: () => import("./views/Admin/ExpertsInformation"),
                    meta: {
                        title: "资料修改"
                    },
                },
            ],
        },
        {
            path: "Project",
            name: "Project",
            component: () => import("./views/Project/Project"),
            meta: {
                title: "项目管理"
            },
            children: [
                {
                    path: "ProjectManage",
                    name: "ProjectManage",
                    component: () => import("./views/Project/ProjectManage"),
                    meta: {
                        title: "立项管理"
                    },
                },
                {
                    path: "ProjectView",
                    name: "ProjectView",
                    component: () => import("./views/Project/ProjectView"),
                    meta: {
                        title: "项目查看"
                    },
                },
            ],
        },
    ]
}];

//教师权限
let route4 = [{
    path: "/main",
    name: "AdminMain",
    component: () => import( "./views/AdminMain"),
    children: [
        {
            path: "admin",
            name: "Admin",
            component: () => import("./views/Admin/Admin"),
            meta: {
                title: "个人中心"
            },
            children: [
                {
                    path: "ChangeInformation",
                    name: "ChangeInformation",
                    component: () => import("./views/Admin/ChangeInformation"),
                    meta: {
                        title: "资料修改"
                    },
                },
                {
                    path: "PersonalProject",
                    name: "PersonalProject",
                    component: () => import("./views/Admin/PersonalProject"),
                    meta: {
                        title: "个人项目查看"
                    },
                },
            ],
        },
        {
            path: "Project",
            name: "Project",
            component: () => import("./views/Project/Project"),
            meta: {
                title: "个人项目管理"
            },
            children: [
                {
                    path: "ProjectApplication",
                    name: "ProjectApplication",
                    component: () => import("./views/Project/ProjectApplication"),
                    meta: {
                        title: "项目申请"
                    },
                },
                {
                    path: "ProjectMember",
                    name: "ProjectMember",
                    component: () => import("./views/Project/ProjectMember"),
                    meta: {
                        title: "项目成员管理"
                    },
                },
            ],
        },
    ]
}];

// console.log(JSON.stringify(route));

/*let year = new Date().getFullYear();
let month = new Date().getMonth();
let day = new Date().getDate();
if (month < 10) {
    month = "0"+month;
}
let i = 1;
i++;
if (i<10) {
    i = "00"+i;
}
if (i<100) {
    i = "0"+i;
}
let number = "NU"+year+month+day+"6"+"1"+i+"ER";
console.log(number);*/


// console.log(Math.floor(new Date().getTime()/(Math.floor(Math.random()*10+1))));


//设置当前session里面路由给vuex，防止刷新页面，直接清空掉vuex里面的数据
store.commit("updateRouteData1");

//全局守卫,可以返回到初始页面,这里需要判断是否为空，因为当不为空到时候，说明路由已经加载上了，需要注意的是路由不用的时候，及时清理，以免造成不必要的麻烦
router.beforeEach((to, from, next) => {
        if (to.name === null) {
            next({name: "Show"});
        } else {
            next();
        }
    }
);

Vue.use(ElementUI);
Vue.use(VueAwesomeSwiper, /* { default global options } */)
new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app');
