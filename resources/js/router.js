import Vue from 'vue'
import Router from  'vue-router'
Vue.use(Router)
import firstPage from './components/pages/myFirstVuePage'
import newRoutePage from './components/pages/newRoutePage'
import hooks from './components/pages/basic/hooks.vue'
import methods from './components/pages/basic/methods.vue'



//project pages
import home from './components/pages/home'
import tags from './admin/pages/tags'
import category from './admin/pages/category'
import adminusers from './admin/pages/adminusers'
import login from './admin/pages/login'
import role from './admin/pages/role'
import assign from './admin/pages/assignRole'
import Blog from './admin/pages/blog'



const routes = [
    //projects  routes....
    {
    path: '/',
    component: home,
    },
    {
        path: '/role',
        component: role,
        name:'role'
    },
    {
        path: '/assign',
        component: assign,
        name:'assign'
    },
    {
        path: '/adminusers',
        component: adminusers,
        name:'adminusers'
    },

    {
        path: '/login',
        component: login,
        name:'login'
    },
    {
        path: '/tags',
        component: tags,
        name:'tags'
    },
 
    {
        path: '/category',
        component: category,
        name: 'category'
    },
    {
        path: '/createblog',
        component: Blog,
        name: 'createblog'
    },
    









































    //basic tutorial app.....
    {
       path: '/my-new-vue-route',
       component: firstPage
    },
    {
        path: '/new-route',
        component: newRoutePage
    },
    //vue hooks 
    {
        path: '/hooks',
        component: hooks
    },
    //more basics
    {
        path: '/methods',
        component: methods
    },

]

export  default new Router({
    mode: 'history',
    routes 
})