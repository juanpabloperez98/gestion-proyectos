import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import DashboardView from '../views/DashboardView.vue'
import AddProjectView from '../views/AddProjectView.vue'
import EditProjectView from '../views/EditProjectView.vue'
import TasksView from '../views/TasksView.vue'
import EditTaskView from '../views/EditTaskView.vue'
import AddTaskView from '../views/AddTaskView.vue'
import RegisterView from '../views/RegisterView.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
    meta: {
      guest: true // Agrega una propiedad meta para indicar que la ruta es para usuarios invitados (no autenticados)
    }
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
    meta: {
      guest: true // Agrega una propiedad meta para indicar que la ruta es para usuarios invitados (no autenticados)
    }
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardView,
    meta: {
      requiresAuth: true // Agrega una propiedad meta para indicar que se requiere autenticación
    }
  },
  {
    path: '/add-project',
    name: 'AddProject',
    component: AddProjectView,
    meta: {
      requiresAuth: true // Agrega una propiedad meta para indicar que se requiere autenticación
    }
  },
  {
    path: '/edit-project/:id',
    name: 'EditProject',
    component: EditProjectView,
    meta: {
      requiresAuth: true // Agrega una propiedad meta para indicar que se requiere autenticación
    }
  },
  {
    path: '/show-tasks/:project_id',
    name: 'Tasks',
    component: TasksView,
    meta: {
      requiresAuth: true // Agrega una propiedad meta para indicar que se requiere autenticación
    }
  },
  {
    path: '/edit-task/:task_id',
    name: 'TasksEdit',
    component: EditTaskView,
    meta: {
      requiresAuth: true // Agrega una propiedad meta para indicar que se requiere autenticación
    }
  },
  {
    path: '/create-task/:project_id',
    name: 'TasksCreate',
    component: AddTaskView,
    meta: {
      requiresAuth: true // Agrega una propiedad meta para indicar que se requiere autenticación
    }
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(route => route.meta.requiresAuth)) {
    if (localStorage.getItem("token")) {
      next();
    } else {
      next('/'); // Redirige a la ruta de inicio de sesión
    }
  }else if (to.matched.some(route => route.meta.guest)){
    if (localStorage.getItem("token")) {
      next('/Dashboard'); // Redirige a la ruta de inicio de sesión
    } else {
      next();
    }
  }else {
    // La ruta no requiere autenticación, permitir acceso
    next();
  }
})

export default router
