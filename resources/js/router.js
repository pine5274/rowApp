import Vue from 'vue'
import VueRouter from 'vue-router'

// ページコンポーネントをインポートする
import RowTable from './pages/RowTable'

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter)

// パスとコンポーネントのマッピング
const routes = [
    {
        path: '/',
        component: RowTable
    },
    {
        path: '/login',
        component: Login
    },
]

// VueRouterインスタンスを作成する
const router = new VueRouter({
    mode: 'history',
    routes
})

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router
