<template>
  <app-layout title="User Create">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User Create
      </h2>
    </template>

       <div class="py-12  h-screen ">
            <div class=" max-w-12xl h-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl sm:rounded-lg">
                     <jet-validation-errors class="mb-4" />
                       <form @submit.prevent="submit">
            <div>
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

        

            <div class="flex items-center justify-end mt-4">
               

                <jet-button class="ml-4 block " :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create User
                </jet-button>
            </div>
        </form>
                   
                </div>
            </div>
        </div>
    

  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
 import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';


export default {
  components: {
    AppLayout,
    JetButton,
    Link,
     Head,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
           
    
    
  },
  data() {
    return {
      confirmingUserDeletion: false,
      form: this.$inertia.form({
          name:'',
          email:'',
        password: "password",
      }),
    };
  },
  computed: {
  
  },
  methods: {
      submit(){
          this.form.post(route('users.store',{
              onSuccess:()=>this.form.reset(),
              onFinish(){

              }
          }))
      }
  },
};
</script>
