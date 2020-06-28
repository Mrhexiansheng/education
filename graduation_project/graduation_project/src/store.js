import Vue from 'vue'
import Vuex from 'vuex'
import router from "@/router"

Vue.use(Vuex);

//生成树结构，返回数据
function loader(routes) {
    routes[0].component = () => import( "./views/AdminMain");
    routes[0].children.forEach(v => {
        v.component = () => import(`./views/${v.name}/${v.name}`);
        v.children.forEach(w => {
            w.component = () => import(`./views/${v.name}/${w.name}`);
        })
    });
    return routes;
}

export default new Vuex.Store({
    state: {
        routeData: []
    },
    mutations: {
        updateRouteData(state, obj) {
            sessionStorage.setItem("route", obj);  //用obj来接收登录页传过来的路由，必须保存下来，不然刷新一下，就没了。另一个session只能保存字符串，不要在parse之后存储
            let routes = JSON.parse(obj);
            state.routeData = routes;  //设置数据，后面就可以从vuex中读取数据
            routes = loader(routes);  //获取路由树结构
            router.addRoutes(routes); //添加路由
            router.push({name: "AdminMain"})  //跳转页面
        },

        //重新发送数据，没有更新state里面存储的值
        updateRouteData1(state) {
            if (sessionStorage.getItem("route")) {
                let obj = sessionStorage.getItem("route");
                let routes = JSON.parse(obj);
                state.routeData = routes;  //设置数据，后面就可以从vuex中读取数据
                routes = loader(routes);  //获取路由树结构
                router.addRoutes(routes); //添加路由
            }
        }
    },
    actions: {},

})
