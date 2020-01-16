<template>
	<v-row justify="center">
		<v-dialog  v-model="dialog" persistent max-width="400">
			<v-card v-if="type == 'login'">
				<v-card-title class="headline">Iniciar Sesión</v-card-title>
				<v-col cols="12" sm="12" md="12">
					<v-form>
						<v-col cols="12" md="12">
							<v-text-field v-model="request.email"  label="E-mail" required></v-text-field>
						</v-col>

						<v-col cols="12" md="12">
							<v-text-field v-model="request.password" type="password" label="Contraseña" required></v-text-field>
						</v-col>
					</v-form>
				</v-col>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" text @click="type = 'register'">Registrar usuario</v-btn>
					<v-btn color="green darken-1" text @click="login()">Iniciar sesión</v-btn>
				</v-card-actions>
			</v-card>
			<v-card v-else>
				<v-card-title class="headline">Registrar Usuario</v-card-title>
				<v-alert v-if="errors.name !=  null"
					color="#C51162"
					dark
					icon="mdi-error"
					border="right"
					>
					<ul v-for="error in errors.name">
						<li>{{error}}</li>
					</ul>
				</v-alert>
				<v-col cols="12" sm="12" md="12">
					<v-form>
						<v-col cols="12" md="12">
							<v-text-field v-model="create.name"  label="Nombre" required></v-text-field>
						</v-col>
						<v-col cols="12" md="12">
							<v-text-field v-model="create.last_name"  label="Apellido" required></v-text-field>
						</v-col>

						<v-col cols="12" md="12">
							<v-text-field v-model="create.email"  type="email" label="E-mail" required></v-text-field>
						</v-col>

						<v-col cols="12" md="12">
							<v-text-field v-model="create.password" type="password" label="Contraseña" required></v-text-field>
						</v-col>
						<v-col cols="12" md="12">
							<v-text-field v-model="create.password_confirmation" type="password" label="Confirmar Contraseña" required></v-text-field>
						</v-col>
						</v-form>
					</v-col>
					<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn color="blue darken-1" text @click="type = 'login'">Iniciar sesión</v-btn>
						<v-btn color="green darken-1" text @click="register()">Registrar Usuario</v-btn>
					</v-card-actions>
				</v-card>

			</v-dialog>
		</v-row>
</template><script>
import axios from 'axios';
import Swal from 'sweetalert2';
export default {
	components:{
	},
	props: {
		dialog: Boolean,
		type: String,
	},
	data () {
		return {
			user: {},
			request : {
				email: '',
				password: ''
			},
			errors:[],
			create: {},
		}
	},
	methods: {
		login(){
			if(this.request.email != '' && this.request.email != ''){
				let urlTest = 'api/apiLogin';
				axios.post(urlTest, this.request).then((response) =>{
					console.log(response);
					if(response.data.status != 'error'){
						localStorage.setItem('user', JSON.stringify(response.data.user));
						console.log(response.data.user);
						this.user = response.data.user;
//						let url = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/admin?api_token=' + response.data.user.api_token;
						let url = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/';
						//console.log(url);
						window.location.href = url;
					}
					else{
						Swal.fire(
							'Error de acceso',
							'Tu contraseña o email son incorrectos',
							'error'
						)
					}
					// this.user = response.data.user;

					// this.warriors = response.data.warriors;
				});
			}
			else{
				Swal.fire(
					'Campos vacios',
					'Los campos deben estar llenos',
					'error'
				);
			}

		},
		register() {
			let urlRegister = 'api/apiRegister';
			axios.post(urlRegister, this.create).then((response) => {
				localStorage.setItem('user', JSON.stringify(response.data.user));
				console.log(response);
				this.user = response;
				let url = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/';
				console.log(url);
				window.location.href = url;
			})
				.catch((error)=>{
					console.log(error.response);
					this.errors = error.response.data.errors;
				});
		},
	},
	mounted(){
	}
}
</script>
