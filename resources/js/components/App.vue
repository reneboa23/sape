<template>
    <v-app id="inspire">
        <Sidebar :drawer.sync="drawer" />
        <v-app-bar :elevation="1" app clipped-left color="blue-grey lighten-5">
            <v-app-bar-nav-icon
                color="blue-grey darken-5"
                @click.stop="drawer = !drawer"
            />
            <v-toolbar-title> SAPE</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-img
                class="text--center"
                :src="imageHeader"
                max-width="250"
            ></v-img>
        </v-app-bar>

        <v-content class="grey lighten-5">
            <v-container>
                <v-row align="baseline" justify="start">
                    <v-col>
                        <router-view></router-view>
                    </v-col>
                </v-row>
            </v-container>
            <BtnConfiguration />
        </v-content>

        <v-footer app color="blue-grey lighten-5">
            <span>
                <small class="caption ">
                    &copy; {{ new Date().getFullYear() }} — EPL Sistema para
                    acompanhamento de projetos estratégicos | Versão do sistema:
                    {{ numVersion }}
                </small>
            </span>
        </v-footer>
    </v-app>
</template>

<script>
import Sidebar from "./Sidebar";
import BtnConfiguration from "../components/BtnConfiguration";
const version = JSON.stringify(require("../../../package.json").version);

export default {
    name: "App",

    components: {
        Sidebar,
        BtnConfiguration
    },
    props: {
        source: String
    },
    data: () => ({
        numVersion: version.replace('"', "").replace('"', ""),
        bottomNav: "recent",
        drawer: true,
        imageHeader: "/imagens/epl_logo.png"
    }),
    created() {
        this.$vuetify.theme.dark = false;
    }
};
</script>

<style></style>
