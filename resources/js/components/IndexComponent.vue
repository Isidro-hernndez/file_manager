<template>
	<div>
		<template>
			<div>
				<v-app-bar color="deep-purple accent-4" dark>
					<v-app-bar-nav-icon></v-app-bar-nav-icon>

					<v-toolbar-title>Page title</v-toolbar-title>

					<v-spacer></v-spacer>

					<v-btn icon>
						<v-icon>mdi-heart</v-icon>
					</v-btn>

					<v-btn icon>
						<v-icon>mdi-magnify</v-icon>
					</v-btn>

					<v-menu left bottom>
						<template v-slot:activator="{ on }">
							<v-btn icon v-on="on">
								<v-icon>mdi-dots-vertical</v-icon>
							</v-btn>
						</template>

						<v-list>
							<v-list-item v-for="n in 5" :key="n" @click="() => {}">
								<v-list-item-title>Option {{ n }}</v-list-item-title>
							</v-list-item>
						</v-list>
					</v-menu>
				</v-app-bar>
			</div>
		</template>
		<v-card>
			<v-navigation-drawer permanent>
				<template v-slot:prepend>
					<v-list>
						<v-list-item>
							<v-list-item-avatar>
								<v-img src="https://randomuser.me/api/portraits/women/85.jpg"></v-img>
							</v-list-item-avatar>
						</v-list-item>

						<v-list-item link two-line>
							<v-list-item-content>
								<v-list-item-title class="title">Sandra Adams</v-list-item-title>
								<v-list-item-subtitle>sandra_a88@gmail.com</v-list-item-subtitle>
							</v-list-item-content>
							<v-list-item-action>
								<v-icon>mdi-menu-down</v-icon>
							</v-list-item-action>
						</v-list-item>
					</v-list>
				</template>

				<v-divider></v-divider>

				<v-list nav dense>
					<v-list-item link>
						<v-list-item-icon>
							<v-icon>mdi-folder</v-icon>
						</v-list-item-icon>
						<v-list-item-title>My Files</v-list-item-title>
					</v-list-item>
					<v-list-item link>
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
					</v-list-item>
				</v-list>
			</v-navigation-drawer>
		</v-card>
	</div>
</template>
