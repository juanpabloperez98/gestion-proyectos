<template>
    <div>
        <HeaderView/>
        <div class="container izquierda">

        <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titulo</th>
                <th scope="col">Descripción</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="task in ListaTasks" :key="task.id">
                <th scope="row">{{ task.id}}</th>
                <th scope="row">{{ task.titulo}}</th>
                <th scope="row">{{ task.description}}</th>
                <th scope="row">{{ task.status}}</th>
                <th scope="row">
                    <a class="btn d-block btn-success" v-on:click="edit(task.id)">Editar task</a>
                    <a class="btn d-block btn-danger"  v-on:click="eliminar(task.id)">Eliminar task</a>
                </th>
            </tr>

        </tbody>
        </table>

        </div>
    </div>
</template>
<script>
import HeaderView from '@/components/HeaderView.vue';
import axios from 'axios';
export default{
    name: "TaskView",
    components:{
        HeaderView,
    },
    data(){
        return {
            ListaTasks:null,
        }
    },
    mounted:function(){
        let url = "http://127.0.0.1:8000/api/task?project_id="+this.$route.params.project_id;
        axios.get(url,{
            headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer' + localStorage.getItem("token")
            }
        }).then( data =>{
            this.ListaTasks = data.data.data;
        });
    },
    methods:{
        edit(id){
            this.$router.push('/edit-task/'+id);
        },
        eliminar(id){
            let url = "http://127.0.0.1:8000/api/task/"+id
            axios.delete(url,{
                headers:{
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer' + localStorage.getItem("token")
                }
            }).then( data =>{
                if(data.status == 200){
                    alert("Eliminado correctamente");
                    this.$router.push('/dashboard');
                }
            });
        },
    }
}
</script>
<style></style>