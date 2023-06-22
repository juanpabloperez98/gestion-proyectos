import Vue from 'vue'
import VueRouter from 'vue-router'
import HomeView from '../views/HomeView.vue'
import DashboardView from '../views/DashboardView.vue'
import AddProjectView from '../views/AddProjectView.vue'
import EditProjectView from '../views/EditProjectView.vue'
import TasksView from '../views/TasksView.vue'
import EditTaskView from '../views/EditTaskView.vue'
import AddTaskView from '../views/AddTaskView.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardView
  },
  {
    path: '/add-project',
    name: 'AddProject',
    component: AddProjectView
  },
  {
    path: '/edit-project/:id',
    name: 'EditProject',
    component: EditProjectView
  },
  {
    path: '/show-tasks/:project_id',
    name: 'Tasks',
    component: TasksView
  },
  {
    path: '/edit-task/:task_id',
    name: 'TasksEdit',
    component: EditTaskView
  },
  {
    path: '/create-task/:project_id',
    name: 'TasksCreate',
    component: AddTaskView
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
