<template>

<div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand ms-5" href="#">Sistema gestión</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto me-5">
        <li class="nav-item active">
          <a class="nav-link" v-on:click="logout()" href="#">Cerrar Sesion</a>
        </li>
      </ul>
    </div>
  </nav>
    <br><br>
</div>
</template>
<script>
export default{
  name: 'HeaderView',
  methods: {
    logout(){
      localStorage.removeItem("token");
      this.$router.push('/');
    }
  }
}
</script>