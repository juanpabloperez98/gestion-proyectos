<template>
    <div>
        <HeaderView/>
            <form v-on:submit.prevent="edit_task" class="widthForm">
                <div class="form-group">
                    <label for="title">Titulo</label>
                    <input type="text" class="form-control" id="title" placeholder="Titulo" v-model="task.titulo">
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea class="form-control" id="description" rows="3" v-model="task.description"></textarea>
                </div>
                <div class="form-group">
                    <label for="status">Estado</label>
                    <select class="form-select" v-model="task.status" aria-label="Default select example">
                        <option value="Pending">Pendiente</option>
                        <option value="In Progress">En Progreso</option>
                        <option value="Completed">Completado</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <input type="submit" class="btn btn-success" value="Editar Proyecto">
                </div>
            </form>
    </div>
</template>
<script>
import HeaderView from '@/components/HeaderView.vue';
import axios from 'axios';

export default{
    name: "DashboardView",
    components:{
        HeaderView,
    },
    data(){
        return {
            task: {
                "titulo": "",
                "description": "",
                "status": "",
                "project_id": "",
            },
        }
    },
    mounted:function(){
        let url = "http://127.0.0.1:8000/api/task/" + this.$route.params.task_id;
        axios.get(url,{
            headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer' + localStorage.getItem("token")
            }
        }).then( data =>{
            this.task = data.data.data
        });
    },
    methods:{
        edit_task(){
            let json = {
                "titulo": this.task.titulo,
                "description": this.task.description,
                "status": this.task.status,
                "project_id": this.task.project_id,
            };
            axios.put(`http://127.0.0.1:8000/api/task/${this.$route.params.task_id}`, json, { headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer' + localStorage.getItem("token")
            }})
                .then( data =>{
                    if(data.status == 200){
                        alert("Tarea actualizada satifactoriamente");
                        this.$router.push('/dashboard');
                    }else{
                        alert("Error al intentar editar");
                    }
            })
        },
    }
}
</script>
<style>
.widthForm{
    width: 600px;
    margin: auto;
}
</style>