//封装请求的方法
import {instance} from "./init";  //从初始化init.js引入实例
//导出需要得方法
export default {
    get(url, data = {}) {
        return instance({
            method: "get",
            url,
            params: data
        })
    },
    post(url, data = {}) {
        return instance({
            method: "post",
            url,
            data
        })
    },
    put(url, data = {}) {
        return instance({
            method: "put",
            url,
            data
        })
    },
    delete(url, data = {}) {
        return instance({
            method: "delete",
            url,
            params: data
        })
    }
}