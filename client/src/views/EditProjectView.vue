<template>
    <div>
        <HeaderView/>
        <form v-on:submit.prevent="edit_project" class="widthForm">
            <div class="form-group">
                <label for="title">Titulo</label>
                <input type="text" class="form-control" id="title" placeholder="Titulo" v-model="project.titulo">
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" rows="3" v-model="project.description"></textarea>
            </div>
            <div class="form-group">
                <label for="date_start">Fecha de inicio</label>
                <input type="text" class="form-control" id="date_start" placeholder="Fecha inicio (YY-MM-DD)" v-model="project.date_start">
            </div>
            <div class="form-group">
                <label for="date_end">Fecha de fin</label>
                <input type="text" class="form-control" id="date_end" placeholder="Fecha fin (YY-MM-DD)" v-model="project.date_end">
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
            project: {
                "titulo": "",
                "description": "",
                "date_start": "",
                "date_end": ""
            },
        }
    },
    mounted:function(){
        let url = "http://127.0.0.1:8000/api/projects/" + this.$route.params.id;
        axios.get(url,{
            headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer' + localStorage.getItem("token")
            }
        }).then( data =>{
            this.project = data.data.data
        });
    },
    methods:{
        edit_project(){
            let json = {
                "titulo": this.project.titulo,
                "description": this.project.description,
                "date_start": this.project.date_start,
                "date_end": this.project.date_end,
            };
            axios.put(`http://127.0.0.1:8000/api/projects/${this.$route.params.id}`, json, { headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer' + localStorage.getItem("token")
            }})
                .then( data =>{
                    if(data.status == 200){
                        alert("Proyecto actualizado satifactoriamente");
                        this.$router.push('/dashboard');
                    }else{
                        alert("Error al intentar agregar");
                    }
            })
        }

    }
}
</script>
<style>
.widthForm{
    width: 600px;
    margin: auto;
}
</style>