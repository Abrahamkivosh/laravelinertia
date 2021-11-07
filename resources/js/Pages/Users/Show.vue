<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User
            </h2>
        </template>

        <div class="py-12">
            <div
                class="
                    max-w-12xl
                    h-full
                    mx-auto
                    sm:px-6
                    lg:px-8
                    flex
                    justify-center
                    items-center
                "
            >
                <div
                    class="
                        bg-white
                        overflow-hidden
                        shadow-xl
                        sm:rounded-lg
                    "
                >
                    <div
                        class="
                            bg-white
                            shadow-md
                            border border-gray-200
                            rounded-lg
                            max-w-sm
                            mb-5
                        "
                    >
                        <a href="#">
                            <img
                                class="rounded-t-lg w-full "
                                :src="usr.profile_photo_url"
                                :alt="usr.name"
                            />
                        </a>
                        <div class="p-5">
                            <a href="#">
                                <h5
                                    class="
                                        text-gray-900
                                        font-bold
                                        text-2xl
                                        tracking-tight
                                        mb-2
                                    "
                                    v-text="usr.name"
                                ></h5>
                            </a>
                            <div>
                               
                                <a :href="userEmail" class="text-blue-500 text-lg py-1" v-text="usr.email" ></a>
                                <div>
                                    Member since
                                    <span
                                        v-text="usr.created_at"
                                        class="text-blue-800"
                                    >
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-row justify-between" >
                                <Link
                                    :href="route('users.index')"
                                    class="text-blue-50 bg-blue-600 rounded-lg px-4 shadow-md py-2"
                                    >Back</Link
                                >
                                <Link
                                    :href="route('users.edit', usr.id)"
                                    class="text-yellow-50 bg-yellow-600 rounded-lg px-4 shadow-md py-2"
                                    >Edit</Link
                                >

                               
                                <a class="text-red-50 bg-red-600 rounded-lg px-4 shadow-md py-2" @click="confirmUserDeletion">
                    Delete Account
                </a>


                 <!-- Delete Account Confirmation Modal -->
            <jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
                <template #title>
                    Delete Account
                </template>

                <template #content>
                    Are you sure you want to delete {{ usr.name }} account? Once your account is deleted,
                     all of its resources and data will be permanently deleted. Please enter your password
                      to confirm you would like to permanently delete {{ usr.name }} account.

                    <div class="mt-4">
                        <jet-input type="password" class="mt-1 block w-3/4" placeholder="Password"
                                    ref="password"
                                    v-model="form.password"
                                    @keyup.enter="deleteUser" />

                        <jet-input-error :message="form.errors.password" class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click="deleteUser" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Account
                    </jet-danger-button>
                </template>
            </jet-dialog-modal>


                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import { Link } from "@inertiajs/inertia-vue3";
   import JetActionSection from '@/Jetstream/ActionSection.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetDangerButton from '@/Jetstream/DangerButton.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default {
    components: {
        AppLayout,
        JetButton,
        Link,
          JetActionSection,
            JetDangerButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
    },
    data() {
        return {
            confirmingUserDeletion: false,
             form: this.$inertia.form({
                    password: '',
                })
        }
    },
    props: ["usr"],
    computed:{
        userEmail(){
           
            return "mailto:"+this.usr.email
        }
    },
    methods: {
         confirmUserDeletion() {
                this.confirmingUserDeletion = true;

                setTimeout(() => this.$refs.password.focus(), 250)
            },
              closeModal() {
                this.confirmingUserDeletion = false

                this.form.reset()
            },
            deleteUser() {
                this.form.delete(route('users.destroy',this.usr.id), {
                    preserveScroll: true,
                    onSuccess: () => this.closeModal(),
                    onError: () => this.$refs.password.focus(),
                    onFinish: () => this.form.reset(),
                })
            },
    },
};
</script>
