<template>
	<v-app id="inspire">
		<v-app-bar app color="indigo" dark>
			<v-toolbar-title>Wearclo</v-toolbar-title>

			<v-spacer></v-spacer>
			<v-btn icon  @click="dialog = true">
				<v-icon>mdi-folder-plus</v-icon>
			</v-btn>
			<v-btn icon @click="file_modal = true">
				<v-icon>mdi-file-plus</v-icon>
			</v-btn>
		</v-app-bar>
		<v-navigation-drawer permanent app color="indigo" dark>
			<template v-slot:prepend>
				<v-list>
					<!--
		 <v-list-item>
		 <v-list-item-avatar>
		 <v-img src="https://randomuser.me/api/portraits/women/85.jpg"></v-img>
		 </v-list-item-avatar>
		 </v-list-item>
					-->
					<v-list-item link two-line>
						<v-list-item-content>
							<v-list-item-title class="title">{{user.name}} {{user.last_name}}</v-list-item-title>
							<v-list-item-subtitle>{{user.email}}</v-list-item-subtitle>
						</v-list-item-content>
						<v-list-item-action>
							<v-icon>mdi-menu-down</v-icon>
						</v-list-item-action>

					</v-list-item>
					<v-list-item >
						<v-list-item-content >
							<v-btn @click="logout()" color="indigo lighten-2" color-text="black" >Cerrar sesión</v-btn>
						</v-list-item-content>
					</v-list-item>
				</v-list>
			</template>

			<v-divider></v-divider>

			<v-list nav dense>
				<v-list-item link v-for="folder in user.folders" :key="folder.id" @click="getFilesFromFolder(folder)">
					<v-list-item-icon>
						<v-icon>mdi-folder</v-icon>
					</v-list-item-icon>
					<v-list-item-title>{{folder.name}}</v-list-item-title>
				</v-list-item>
				<!--<v-list-item link>
		<v-list-item-icon>
		<v-icon>mdi-account-multiple</v-icon>
		</v-list-item-icon>
		<v-list-item-title>Shared with me</v-list-item-title>
		</v-list-item>
		<v-list-item link>
		<v-list-item-icon>
		<v-icon>mdi-star</v-icon>
		</v-list-item-icon>
		<v-list-item-title>Starred</v-list-item-title>
		</v-list-item>-->
			</v-list>

		</v-navigation-drawer>

		<v-content>

			<v-container class="fill-height" fluid>
				<v-row align="center" justify="center">
				<!--	<v-col class="text-center">
						<pre>{{ user }}</pre>
						<pre>{{ files }}</pre>
						<pre>{{ dialog }}</pre>

				</v-col>-->
					<template>
						<v-card class="d-inline-block mx-auto" v-for="file in user.files" :key="file.id">
							<v-container>
								<v-row justify="space-between">
									<v-col cols="auto">
										<v-img height="200"	width="200" :src="file.url"></v-img>
									</v-col>

									<v-col cols="auto" class="text-center pl-0">
										<v-row class="flex-column ma-0 fill-height" justify="center">
											<v-col class="px-0">
												<a :href="file.url" download>
													<v-btn icon>
														<v-icon>mdi-file-download</v-icon>
													</v-btn>
												</a>
											</v-col>

										<!--	<v-col class="px-0">
												<v-btn icon>
													<v-icon>mdi-delete</v-icon>
												</v-btn>
										</v-col>-->
										</v-row>
									</v-col>
								</v-row>
							</v-container>
						</v-card>
					</template>
				</v-row>
			</v-container>
		</v-content>
		<v-footer color="indigo" app>
			<span class="white--text">&copy; Developed by <a href="www.isidro.dev"> www.isidro.dev</a> 2020</span>
		</v-footer>
		<!---->
		<template>
			<v-row justify="center">
				<v-dialog v-model="not_user" persistent max-width="400">
					<v-card>
						<v-card-title class="headline">Sesión no iniciada</v-card-title>
						<v-card-text>
							No hay sesión iniciada, por favor ingresa o registrate
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="blue darken-1" outlined text @click="activeAuth('register')">Registrar</v-btn>
							<v-btn color="blue darken-1" outlined text @click="activeAuth('login')">Ingresar</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</v-row>
		</template>


		<!---->
		<template>
			<v-row justify="center">
				<v-dialog v-model="dialog" persistent max-width="290">
					<v-card>
						<v-card-title class="headline">Crear Nueva Carpeta</v-card-title>
						<v-col cols="12" sm="12" md="12">
							<v-text-field label="Nombre de la carpeta" outlined v-model="new_folder"></v-text-field>
						</v-col>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="green darken-1" text @click="dialog = false">Cancelar</v-btn>
							<v-btn color="green darken-1" text @click="createFolder()">Crear</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</v-row>
		</template>
		<!---->
		<template>
			<v-row justify="center">
				<v-dialog v-model="file_modal" persistent max-width="400">
					<v-card v-if="user.folders.length > 0">
						<v-card-title class="headline">Subir Archivo</v-card-title>
						<v-col class="d-flex" cols="12" sm="12">
							<v-select v-model="folder_selected" :items="user.folders" item-text="name" item-value="id" label="Seleccionar Carpteta" outlined ></v-select>
						</v-col>
						<v-col cols="12" sm="12" md="12">
							<v-file-input v-model="files" color="deep-purple accent-4" counter label="Subir Archivo" multiple placeholder="Selecciona tu archivo" prepend-icon="mdi-paperclip" outlined :show-size="1000" >
								<template v-slot:selection="{ index, text }">
									<v-chip v-if="index < 2" color="deep-purple accent-4" dark label small>
										{{ text }}
									</v-chip>

								<span v-else-if="index === 2" class="overline grey--text text--darken-3 mx-2">
									+{{ files.length - 2 }} File(s)
								</span>
								</template>
							</v-file-input>
						</v-col>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="green darken-1" text @click="file_modal = false">Cancelar</v-btn>
							<v-btn color="green darken-1" text @click="uploadFile()">Crear</v-btn>
						</v-card-actions>
					</v-card>
					<v-card v-else>
						<v-card-title>
							No hay carpetas creadas actualmente
						</v-card-title>
						<v-card-text>
							Por favor para subir un archivo primero deber crear una carpeta
						</v-card-text>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="green darken-1" text @click="file_modal = false">Cancelar</v-btn>
							<v-btn color="green darken-1" text disabled @click="createFolder()">Crear</v-btn>
						</v-card-actions>
					</v-card>
				</v-dialog>
			</v-row>
		</template>
		<auth-component :dialog="active_auth" :type="type_auth" v-show="active_auth"></auth-component>
	</v-app>
</template>
<script>
import AuthComponent from './AuthComponent.vue';
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
	name: 'IndexComponent',
	components: { 
		AuthComponent
	},
	props: {
		source: String,
	},
	data() {
		return {
			not_user : false,
			user: {
				folders: [],
			},
			drawer: null,
			dialog: false,
			new_folder: '',
			file_modal: false,
			files: [],
			active_auth: false,
			type_auth: '',
			folder_selected: '',
		}
	},
	filters: {

	},
	computed: {

	},
	methods: {
		getFilesFromFolder(folder){
			let url = 'api/carpetas/archivos?api_token=' + this.user.api_token;

			axios.post(url, {folder_id: folder.id})
				.then((response) => {
					console.log(response);
					if(response.data.status != 'error'){
						this.user.files = response.data.files;
					}
				});
		},
		logout(){
			console.log('logout');
			let urlData = 'api/apiLogout';
			axios.post(urlData, {api_token: this.user.api_token}).then((response) => {
				console.log(response);
				if(response.data.status != 'error'){
					localStorage.clear();
					let url = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/';
					console.log(url);
					window.location.href = url;
				}
			});
		},
		activeAuth(type){
			this.active_auth = true;
			this.type_auth = type;
			this.not_user = false;
		},
		getData() {
			axios.get('api/usuarios?id=1')
				.then((response) => {
					this.user = response.data.user;
					console.log(this.user);
				});
		},
		createFolder() {
			axios.post('api/carpetas/crear?api_token=' + this.user.api_token, {name: this.new_folder })
				.then((response) => {
					console.log(response.data);
					if(response.data.status != 'error'){
						this.user.folders.push(response.data.folder);
						this.dialog = false;
						this.new_folder = '';
					}
				})
				.catch((error)=>{
					console.log(error.response);
				});

		},
		uploadFile() {
			console.log(this.folder_selected);
			console.log(this.files);
			if(this.folder_selected != '' && this.files.length > 0)
			{
				let formData = new FormData();
				formData.append('file', this.files[0]);
				formData.append('folder_id', this.folder_selected);
				let url = 'api/archivos/crear?api_token=' + this.user.api_token;
				axios.post(url, formData, { headers: { 'Content-Type': 'multipart/form-data'},  })
					.then((response) => {
						console.log(response.data);
						let title = 'Ocurrio un problema';
						if(response.data.status != 'error'){
							title = 'Alamacenamiento Exitoso';	
							this.file_modal = false;
							this.user.files.push(response.data.file);
						}
						Swal.fire(
							title,
							response.data.message,
							response.data.status,
						);
					});
			}
			else {
				Swal.fire(
					'Error!',
					'Por favor elige el archivo a subir y la carpeta donde se almacenara',
					'warning'
				)
			}
		},
	},
	mounted() {
		let user = JSON.parse(localStorage.getItem('user'));
		if ( user ){
			this.getData();
		}
		else {
			this.not_user = true;
		}
	},

};
</script>
