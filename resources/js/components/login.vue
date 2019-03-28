<template>
  <b-container class="my-5">
    <b-row class="justify-content-md-center">
      <b-col md="4">
        <div>
          <b-card class="text-center" img-src="../img/comers_logo.png" img-top>
            <hr>
            <h4 class="text-primary">Iniciar sesión</h4>
            <b-row class="my-2">
              <b-col md="12">
                <b-form-input type="text" placeholder="Correo electrónico" v-model="email"/>
              </b-col>
            </b-row>
            <b-row class="my-2">
              <b-col md="12">
                <b-form-input type="password" placeholder="Contraseña"  v-model="password"/>
              </b-col>
            </b-row>
            <b-row class="my-2">
              <b-col md="12">
                <b-button block variant="outline-primary">Ingresar</b-button>
              </b-col>
            </b-row>
          </b-card>
        </div>
      </b-col>
    </b-row>
  </b-container>

</template>
<script>
export default {
  data: () => ({
     email:'',
     password:''

  })
}
</script>
