<template>
    <app-layout title="TodoList">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todo List
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-auto shadow-xl sm:rounded-lg">
                    <div>
                        <div
                            v-if="message.status"
                            class="
                                py-2
                                px-2
                                text-green-800
                                bg-blue-400
                                rounded-lg
                                shadow-md
                            "
                        >
                            {{ message.text }}
                        </div>
                        <form
                            action=""
                            @submit.prevent="processform"
                            method="post"
                        >
                            <div>
                                <jet-label for="name" value="name" />
                                <jet-input
                                    id="name"
                                    type="name"
                                    class="
                                        mt-1
                                        block
                                        w-full
                                        py-3
                                        px-2
                                        font-mono
                                        text-black
                                        border-2
                                    "
                                    v-model="form.name"
                                    required
                                    placeholder="what to do ..."
                                    autofocus
                                />
                            </div>
                            <jet-button
                                class="ml-4 block items-center justify-center"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Create Todo
                            </jet-button>
                        </form>
                    </div>
                    <div class="pt-6">
                        <ul
                            class="flex flex-row justify-center"
                            v-for="(todo, index) in todos"
                            :key="index"
                        >
                            <li  class=" py-3 px-2 mb-2
                                    bg-blue-200      shadow-sm
                                    rounded-md    w-full
                                    text-lg
                                    first-letter:capitalize  font-serif     text-left        flex     flex-column
                                "
                                :class="{ 'text-red-500': todo.completed }"
                            >
                                <span class=" justify-start" >
                                    <jet-checkbox
                                        name="complete"
                                        check
                                        @click="completetask(todo)"
                                    />
                                </span>
                                <span class=" left-6 pl-6" > {{ todo.name }} </span>
                               
                                <span v-if="todo.completed" class=" font-bold  pl-12 "  > {{ todo.completed_at }} </span>
                                <span @click="deleteTask(todo)"  class="text-red-800 font-bold float-right  pl-12    w-2 h-2  text-4xl rounded-lg  w-2 h-2 delete ">*</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import axios from 'axios';
export default {
  components: {
    AppLayout,
    JetButton,
    JetInput,
    JetCheckbox,
    JetLabel,
  },
  data() {
    return {
      form: {
        name: "",
        processing:false
      },
      todoupdate:{
          name:"",
          completed:true
      },

      todos:[],
      message:{status:false,text:""}
    };
  },
  computed: {},
  methods: {
      processform(){
          this.form.processing = true
          
          axios.post('http://myapp.myproject.test/api/todos',this.form).then(response=>{
              this.message.status = true
              this.message.text = response.data.message
              this.form.name = ""
              this.incomingTodos()
          }).catch(error=>console.error(error)).finally( function(){
              this.form.processing = false
              console.log(this.form)
              setTimeout(() => {
                   this.message.status = false
              }, 5000);

          } )
          this.form.processing = false
      },
      incomingTodos(){
          axios.get("http://myapp.myproject.test/api/todos").then((response)=>{
              this.todos = response.data.data

          }).catch((error)=>{
              alert(error)
          }).finally(()=>{

          })
      },
      completetask(todo){
     
             todo.completed  =!  todo.completed

            axios.put(`http://myapp.myproject.test/api/todos/${todo.id}`,todo).then((response)=>{

                this.message.status = true
                this.message.text = response.data.message
                this.incomingTodos()
          }).catch((error)=>{
              alert(error)
          }).finally(()=>{
               setTimeout(() => {
                   this.message.status = false
              }, 5000);
          })
       

      },
      deleteTask(todo){

       let confm =   confirm("are you sure you need to delete ?")

       if(confm){
           
            axios.delete(`http://myapp.myproject.test/api/todos/${todo.id}`).then((response)=>{
                this.message.status = true
                this.message.text = response.data.message
                this.incomingTodos()
          }).catch((error)=>{
              alert(error)
          }).finally(()=>{
               setTimeout(() => {
                   this.message.status = false
              }, 5000);
          })
       
       }

      }





  },
  watch: {},
  created() {
      this.incomingTodos()
  },
};
</script>

<style>

.delete{
    cursor: pointer;
    float: right;

}

</style>
