<template>
    <v-row v-if="project">
        <v-col cols="12" md="5">
            <v-row justify="start" align="start">
                <v-col cols="12">
                    <v-card outlined>
                        <v-card-title>
                            <span
                                >{{ project.data.attributes.name }}
                                <BtnEditProject
                                    :hasSession="hasSession"
                                    :item="project"
                            /></span>
                        </v-card-title>
                        <v-divider></v-divider>
                        <v-card-text>
                            <p>{{ project.data.attributes.description }}</p>

                            <p>
                                <projectDetails
                                    class="mt-3"
                                    :hasSession="hasSession"
                                />
                            </p>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>
        <v-col cols="12" md="7">
            <v-row>
                <!--  <v-col cols="12">
          <ProjectMapLayers />
        </v-col>-->
                <v-col cols="12">
                    <ProjectStepper />
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</template>

<script>
import { mapGetters } from "vuex";
import ProjectStepper from "../components/ProjectStepper";
import ProjectDetails from "../components/ProjectDetails";
import ProjectMapLayers from "../components/ProjectMapLayers";
import BtnEditProject from "../components/BtnEditProject";

export default {
    name: "ShowProject",
    components: {
        ProjectStepper,
        ProjectDetails,
        ProjectMapLayers,
        BtnEditProject
    },
    computed: {
        ...mapGetters(["project"])
    },
    data() {
        return {
            hasSession: true
        };
    }
};
</script>

<style></style>
