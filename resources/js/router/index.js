import { createRouter, createWebHistory } from 'vue-router'
import ExampleComponent from '../components/ExampleComponent.vue'

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      component: ExampleComponent,
      
    },
  ],
})
