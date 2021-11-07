<template>
<app-layout >
    <template #header >
        <h2 class="text-2xl text-black leading-relaxed "> System usrs </h2>
    </template>
    <div class="py-12">
        <div class="max-w-12xl w-auto sm:px-6 lg:px-8 ">

            <section class="container mx-auto p-6 font-mono">
  <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
    <div class="w-full overflow-x-auto">

         <jet-form-section @submitted="updateUserProfile">
        <template #title>
           {{ usr.name }} Profile Information
        </template>

        <template #description>
            Update your account's profile information and email address.
        </template>

        <template #form>
         

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.errors.email" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>


     
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
import JetFormSection from '@/Jetstream/FormSection.vue'
 import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default {
    components: {
            AppLayout,
            Link,
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },
        
        props:["usr"],
        data() {
            return {
                form:this.$inertia.form({
                    _method:'PUT',
                    name:this.usr.name,
                    email:this.usr.email,
                })
            }
        },
        created() {
        },
        methods: {
          
            updateUserProfile(){
                this.form.post(route('users.update',this.usr.id),{
                    errorBag:"updateUserProfile",
                    onSuccess(){
                        alert("updated")
                    }
                })

            }
        },

}
</script>


<style>

</style>