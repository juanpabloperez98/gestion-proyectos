<template>
    <div>
        <HeaderView/>
        <form v-on:submit.prevent="add_project" class="widthForm">
            <div class="form-group">
                <label for="title">Titulo</label>
                <input type="text" class="form-control" id="title" placeholder="Titulo" v-model="title">
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea class="form-control" id="description" rows="3" v-model="description"></textarea>
            </div>
            <div class="form-group">
                <label for="date_start">Fecha de inicio</label>
                <input type="text" class="form-control" id="date_start" placeholder="Fecha inicio (YY-MM-DD)" v-model="date_start">
            </div>
            <div class="form-group">
                <label for="date_end">Fecha de fin</label>
                <input type="text" class="form-control" id="date_end" placeholder="Fecha fin (YY-MM-DD)" v-model="date_end">
            </div>
            <div class="form-group mt-3">
                <input type="submit" class="btn btn-success" value="Agregar Proyecto">
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
            title: "",
            description: "",
            date_start: "",
            date_end: "",
        }
    },
    methods:{
        add_project(){
            let json = {
                "titulo" : this.title,
                "description": this.description,
                "date_start": this.date_start,
                "date_end": this.date_end,
            };
            console.log(json);
            axios.post(`http://127.0.0.1:8000/api/projects`, json, { headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer' + localStorage.getItem("token")
            }})
                .then( data =>{
                    if(data.status == 201){
                        alert("Proyecto creado satifactoriamente");
                        this.$router.push('dashboard');
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