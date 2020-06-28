//初始化配置
import axios from 'axios';
const instance = axios.create({
    timeout:3000
});
export {instance};