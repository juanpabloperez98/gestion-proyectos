<template>
    <div>
        <HeaderView/>
        <div class="container izquierda">

            <div class="row">
                <div class="col-6">
                    <a class="btn btn-primary" href="/add-project">Agregar proyecto</a>
                </div>
                <div class="col-6">
                    <form>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" v-model="date_start" placeholder="Fecha inicio (YY-MM-DD)">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" v-model="date_end" placeholder="Fecha fin (YY-MM-DD)">
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-success" v-on:click="filter()">Buscar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br><br>

            


            <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Titulo</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Fecha de inicio</th>
                    <th scope="col">Fecha de fin</th>
                    <th scope="col">Nombre del usuario</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="proyecto in ListaPoryectos" :key="proyecto.id">
                    <th scope="row">{{ proyecto.id}}</th>
                    <th scope="row">{{ proyecto.titulo}}</th>
                    <th scope="row">{{ proyecto.description}}</th>
                    <th scope="row">{{ proyecto.date_start}}</th>
                    <th scope="row">{{ proyecto.date_end}}</th>
                    <th scope="row">{{ proyecto.user.name}}</th>
                    <th scope="row">
                        <a class="btn d-block btn-primary" v-on:click="add_task(proyecto.id)">Agregar tarea</a>
                        <a class="btn d-block btn-warning" v-on:click="show_tasks(proyecto.id)">Ver tareas</a>
                        <a class="btn d-block btn-success" v-on:click="edit(proyecto.id)">Editar proyecto</a>
                        <a class="btn d-block btn-danger" v-on:click="eliminar(proyecto.id)">Eliminar proyecto</a>
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
    name: "DashboardView",
    data(){
        return {
            ListaPoryectos:null,
            date_start:"",
            date_end:""
        }
    },
    components:{
        HeaderView,
    },
    mounted:function(){
        let direccion = "http://127.0.0.1:8000/api/projects"
        axios.get(direccion,{
            headers:{
                'Content-Type': 'application/json',
                'Authorization': 'Bearer' + localStorage.getItem("token")
            }
        }).then( data =>{
            this.ListaPoryectos = data.data.data;
        });
    },
    methods:{
        edit(id){
            this.$router.push('/edit-project/'+id);
        },
        eliminar(id){
            let url = "http://127.0.0.1:8000/api/projects/"+id
            axios.delete(url,{
                headers:{
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer' + localStorage.getItem("token")
                }
            }).then( data =>{
                if(data.status == 200){
                    alert("Eliminado correctamente");
                    window.location.reload();
                }
            });
        },
        show_tasks(id){
            this.$router.push('/show-tasks/'+id);
        },
        add_task(id){
            this.$router.push('/create-task/'+id);
        },
        filter(){
            if(this.date_start == "" && this.date_end == ""){
                alert("Es necesario indicar almenos un campo")
            }else{
                let direccion = "http://127.0.0.1:8000/api/project/filter?"
                if(this.date_start != ""){
                    direccion += "date_start="+this.date_start
                }
                if(this.date_end != ""){
                    direccion += this.date_start != "" ? "&" : "";
                    direccion += "date_end="+this.date_end
                }
                axios.get(direccion,{
                    headers:{
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer' + localStorage.getItem("token")
                    }
                }).then( data =>{
                    this.ListaPoryectos = data.data.data;
                });
            }
        }
    }
}
</script>
<style>
    .izquierda{
        text-align: left;
    }
</style>