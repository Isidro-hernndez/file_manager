<template>
	<v-app id="inspire">
	  <v-app-bar app
	  color="indigo"
	  dark>
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
			</v-list>
		</template>

		<v-divider></v-divider>

		<v-list nav dense>
			<v-list-item link v-for="folder in user.folders">
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

		<pre>{{ user }}</pre>
		<pre>{{ dialog }}</pre>
		<v-container
		  class="fill-height"
		  fluid
		>
		  <v-row
			align="center"
			justify="center"
		  >
			<v-col class="text-center">
			  <v-tooltip left>
				<template v-slot:activator="{ on }">
				  <v-btn
					:href="source"
					icon
					large
					target="_blank"
					v-on="on"
				  >
					<v-icon large>mdi-code-tags</v-icon>
				  </v-btn>
				</template>
				<span>Source</span>
			  </v-tooltip>
  
			  <v-tooltip right>
				<template v-slot:activator="{ on }">
				  <v-btn
					icon
					large
					href="https://codepen.io/johnjleider/pen/zgxeLQ"
					target="_blank"
					v-on="on"
				  >
					<v-icon large>mdi-codepen</v-icon>
				  </v-btn>
				</template>
				<span>Codepen</span>
			  </v-tooltip>
			</v-col>
		  </v-row>
		</v-container>
	  </v-content>
	  <v-footer
		color="indigo"
		app
	  >
		<span class="white--text">&copy; 2019</span>
	  </v-footer>
	  <template>
		<v-row justify="center">
		  <v-dialog v-model="dialog" persistent max-width="290">
			<v-card>
			  <v-card-title class="headline">Crear Nueva Carpeta</v-card-title>
			  <v-col cols="12" sm="12" md="12">
				<v-text-field
				  label="Nombre de la carpeta"
				  outlined
				  v-model="new_folder"
				></v-text-field>
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
			<v-dialog v-model="file_modal" persistent max-width="290">
			  <v-card>
				<v-card-title class="headline">Subir Archivo</v-card-title>
				<v-col cols="12" sm="12" md="12">
					<v-file-input
						v-model="files"
						color="deep-purple accent-4"
						counter
						label="File input"
						multiple
						placeholder="Select your files"
						prepend-icon="mdi-paperclip"
						outlined
						:show-size="1000"
					>
						<template v-slot:selection="{ index, text }">
						<v-chip
							v-if="index < 2"
							color="deep-purple accent-4"
							dark
							label
							small
						>
							{{ text }}
						</v-chip>

						<span
							v-else-if="index === 2"
							class="overline grey--text text--darken-3 mx-2"
						>
							+{{ files.length - 2 }} File(s)
						</span>
						</template>
					</v-file-input>
				</v-col>
				<v-card-actions>
				  <v-spacer></v-spacer>
				  <v-btn color="green darken-1" text @click="file_modal = false">Cancelar</v-btn>
				  <v-btn color="green darken-1" text @click="createFolder()">Crear</v-btn>
				</v-card-actions>
			  </v-card>
			</v-dialog>
		  </v-row>
		</template>

	</v-app>
  </template>
<script>
import axios from 'axios';
	export default {
		   name: 'IndexComponent',
		   components: { 
		   },
		   props: {
		    source: String,
		   },
		   data() {
			   return {
				   user: {},
				   drawer: null,
				   dialog: false,
				   new_folder: '',
				   file_modal: false,
				   files: [],
			   }
		   },
		   filters: {
			
		   },
		   computed: {
						 
		   },
		   methods: {
				getData() {
					axios.get('api/usuarios?id=1')
					.then((response) => {
						this.user = response.data.user;
						console.log(this.user);
					});
				},
				createFolder() {
					axios.post('api/carpetas/crear', {name: this.new_folder, user_id: this.user.id})
					.then((response) => {
						console.log(response.data);
						if(response.data.status != 'error'){
							this.user.folders.push(response.data.folder);
							this.dialog = false;
							this.new_folder = '';
						}
					})
				}
		   },
		   mounted() {
				this.getData();
		   },
			
	   };
   </script>