<template>
<app-layout >
    <template #header >
        <h2 class="text-2xl text-black leading-relaxed "> System usrs </h2>
    </template>
    <div class="py-12">
        <div class="max-w-12xl w-auto sm:px-6 lg:px-8 ">
            <div class="">
                <Link :href="route('users.create')" class="text-blue-50 text-lg bg-blue-800 rounded-lg float-right px-4  py-2">Create User </Link>
                </div>



            <section class="container mx-auto p-6 font-mono">
  <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
    <div class="w-full overflow-x-auto">
      <table class="w-full">
        <thead>
          <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
            <th class="px-4 py-3">Name</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Created </th>
            <th class=" px-4 py-3 " >Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white">
           
          <tr class="text-gray-700" v-for="(usr, index) in users" :key="index" >
            <td class="px-4 py-3 border">
              <div class="flex items-center text-sm">
                <div class="relative w-8 h-8 mr-3 rounded-full md:block">
                  <img class="object-cover w-full h-full rounded-full" :src="usr.profile_photo_url" :alt="usr.name" loading="lazy" />
                  <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                </div>
                <div>
                  <p class="font-semibold text-black">{{ usr.name }}</p>
                </div>
              </div>
            </td>
            <td class="px-4 py-3 text-xs border">
              <span class="px-2 py-1 font-semibold leading-tight text-green-700  rounded-sm"> {{ usr.email }} </span>
            </td>
            <td class="px-4 py-3 text-sm border">{{ usr.created_at }}</td>
            <td class="px-4 py-3 text-sm border justify-evenly  ">
                <Link :href="route('users.show',usr.id)"
                 class="text-center text-blue-300 bg-blue-800  pl-3 rounded py-2 px-4 ml-0 ">
                    View
                </Link>
                <Link :href="route('users.edit',usr.id)"
                 class="text-center text-green-300 bg-green-800 pl-3 rounded py-2 px-4 ml-1 ">
                    Edit
                </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

        </div>
    </div>
</app-layout>
  
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/inertia-vue3';
 import JetButton from '@/Jetstream/Button.vue'


export default {
    components: {
            AppLayout,Link,JetButton
        },
        
        props:["users"],
        data() {
            return {
            }
        },
      
        methods: {
            getUsers(){
                this.users
            }
        },

}
</script>


<style>

</style>