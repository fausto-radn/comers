<template>
  <b-container class="my-5">
    <b-row class="justify-content-md-center">
      <b-col md="10">
        <div>
          <b-card>
            {{ totalRows }}
            <b-row class="my-2">
              <b-col md="8" class="my-2">
                <b-form-input type="text" placeholder="Buscar" v-model="filter" />
              </b-col>
              <b-col md="4" class="my-2">
                <b-button block variant="outline-success" @click="dialog = !dialog">Agregar Usuario</b-button>
              </b-col>
            </b-row>

            <b-row class="my-2">
              <b-col md="12">
                <!-- Main table element -->
                <b-table
                show-empty
                responsive
                :items="users"
                :fields="fields"
                :filter="filter"
                :current-page="currentPage"
                :per-page="perPage"
                @filtered="onFiltered"
                >
                <template slot="actions" slot-scope="row">
                  <b-button-group>
                    <b-button size="sm" variant="outline-info" class="mx-2" >
                      Detalles
                    </b-button>
                    <b-button size="sm" variant="outline-warning" class="mx-2" @click="editItem(row.item)">
                      Editar
                    </b-button>
                    <b-button size="sm" variant="outline-danger" class="mx-2" @click="deleteItem(row.item)">
                      Eliminar
                    </b-button>
                  </b-button-group>
                </template>
              </b-table>
              <b-pagination
              :total-rows="totalRows"
              :per-page="perPage"
              v-model="currentPage"
              class="my-0"
              />
            </b-col>
          </b-row>
        </b-card>
      </div>
    </b-col>
  </b-row>

  <b-modal v-model="dialog" :title="modalTitle">
    <b-form-group label="Nombre(s)" label-cols-sm="4">
      <b-form-input type="text" v-model="editedItem.names" :state="errors.names == undefined ? null:false" />
      <b-form-invalid-feedback>
        {{ errors.names }}
      </b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Apellido Paterno" label-cols-sm="4">
      <b-form-input type="text" v-model="editedItem.first_surname" :state="errors.first_surname == undefined ? null:false"/>
      <b-form-invalid-feedback>
        {{ errors.first_surname }}
      </b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Apellido Matarno" label-cols-sm="4">
      <b-form-input type="text" v-model="editedItem.second_surname" :state="errors.second_surname == undefined ? null:false"/>
      <b-form-invalid-feedback>
        {{ errors.second_surname }}
      </b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Correo Electrónico" label-cols-sm="4">
      <b-form-input type="text" v-model="editedItem.email" :state="errors.email == undefined ? null:false"/>
      <b-form-invalid-feedback>
        {{ errors.email }}
      </b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Tipo de Usuario" label-cols-sm="4">
      <b-form-select :options="options" v-model="editedItem.role" :state="errors.role == undefined ? null:false">
      </b-form-select>
      <b-form-invalid-feedback>
        {{ errors.role }}
      </b-form-invalid-feedback>
    </b-form-group>
    <b-form-group label="Contraseña" label-cols-sm="4" >
      <b-form-input type="password" v-model="editedItem.password" :state="errors.password == undefined ? null:false"/>
      <b-form-invalid-feedback>
        {{ errors.password }}
      </b-form-invalid-feedback>
    </b-form-group>

    <div slot="modal-footer">
      <b-button variant="outline-secondary" @click="dialog=false">Cancelar</b-button>
      <b-button variant="outline-success" @click="save">Guardar</b-button>
    </div>
  </b-modal>
</b-container>

</template>
<script>
export default {
  data: () => ({
    mr:'asdasd',
    dialog:false,
    users:[],
    options:[
      { value: 'USER', text: 'USUARIO' },
      { value: 'ADMIN', text: 'ADMINISTRADOR' },
    ],

    fields: [
      { key: 'names', label: 'Nombres', sortable: true},
      { key: 'first_surname', label: 'Apellido Paterno', sortable: true},
      { key: 'second_surname', label: 'Apellido Materno', sortable: true},
      { key: 'actions', label: 'Actiones' }
    ],
    filter:null,
    currentPage: 1,
    perPage: 2,
    totalRows:0,
    editedIndex: -1,
    editedItem: {
      id:'',
      names:'',
      first_surname:'',
      second_surname:'',
      email:'',
      role:'',
      password:''
    },
    defaultItem: {
      id:'',
      names:'',
      first_surname:'',
      second_surname:'',
      email:'',
      role:'',
      password:''
    },
    errors:[]
  }),
  watch: {
    dialog(val) {
      val || this.close();
    },
  },
  computed: {
    modalTitle() {
      return this.editedIndex === -1 ? "Agregar Usuario" : "Editar Usuario";
    },
    isDisabled() {
      return this.editedIndex === -1 ? false : true;
    },
  },
  created() {
    this.getUsers();
  },
  methods: {
    getUsers(){
      let url = "api/users";
      axios.get(url).then(response => {
        this.users = response.data.users;
        this.totalRows = this.users.length
      });
    },
    editItem(item) {
      this.editedIndex = this.users.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    save(){
      if (this.editedIndex > -1) {
        //update
        let url = "api/users/" + this.editedItem.id;
        axios
        .put(url, this.editedItem)
        .then(response => {
          Object.assign(this.users[this.editedIndex], response.data.user);
          //Object.assign(this.items[this.editedIndex], this.editedItem)
          this.close();
          swal("Correcto!", response.data.message, "success");
        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            this.close();
            swal(
              "Error!",
              error.response.status + " " + error.response.statusText,
              "warning"
            );
          }
        });
      }else{
        let url = 'api/users'
        axios
        .post(url, this.editedItem)
        .then(response => {
          this.users.push(response.data.user);
          this.totalRows++;
          this.close();
          swal("Correcto!", response.data.message, "success");
        })
        .catch(error => {
          if (error.response.status == 422) {
            this.errors = error.response.data.errors;
          } else {
            swal(
              "Error!",
              error.response.status + " " + error.response.statusText,
              "warning"
            );
            this.close();
          }
        });
      }
    },
    deleteItem(item) {
      swal({
        title: "¿Estás seguro?",
        text: "Esté elemento se eliminará.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        buttons: ["No, Cancelar", "Si, Eliminar!"]
      }).then(willDelete => {
        if (willDelete) {
          let url = "api/users/" + item.id;
          axios
            .delete(url)
            .then(response => {
              const index = this.users.indexOf(item);
              this.users.splice(index, 1);
              this.totalRows--;
              this.currentPage = 1; //crear formula para moverse ala pagina actual
              swal("Correcto!", response.data.message, "success");
            })
            .catch(error => {
              swal(
                "Error!",
                error.response.status + " " + error.response.statusText,
                "warning"
              );
            });
        }
      });
    },
    close() {
      this.dialog = false;
      this.errors = [];
      setTimeout(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      }, 300);
    },
    onFiltered(filteredItems) {
      // Trigger pagination to update the number of buttons/pages due to filtering
      this.totalRows = filteredItems.length
      this.currentPage = 1
    }
  }
}
</script>
