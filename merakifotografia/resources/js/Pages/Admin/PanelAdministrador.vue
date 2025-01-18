<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue'; // Importación de funciones de Vue
import { router, useForm } from '@inertiajs/vue3'; // Importación del enrutador y useForm de Inertia
import GestionarCategorias from './GestionarCategorias.vue';
import GestionarReportajes from './GestionarReportajes.vue';
import GestionarUsuarios from './GestionarUsuarios.vue';

const seccionSeleccionada = ref('gestionarCategorias');

const props = defineProps({
    'categorias' :{
        type: Array,
        default: () => [],
    },

    'reportajes' : {
        type: Array,
        default: () => [],
    },

    'users' : {
        type: Array,
        default: () => [],
    },

    'roles' : {
        type: Array,
        default: () => [],
    },
})

const cambiarSeccion = (seccion) => {
    seccionSeleccionada.value = seccion;
}
</script>

<template>
    <Head title="Panel De Administrador" />

    <AuthenticatedLayout>
         <div class="bg-gradient-to-r from-amethyst-3 to-amethyst-6 py-4 shadow-lg">
            <h2 class="text-4xl font-bold text-center pb-4 text-black">Panel De Administrador</h2>
            <nav class="flex justify-center ">
                <ul class="flex gap-6 text-black font-medium px-2">
                    <li
                        class="cursor-pointer py-2 px-4 rounded-md transition-all duration-300"
                        :class="{'bg-amethyst-8 text-black': seccionSeleccionada === 'gestionarCategorias'}"
                        @click="cambiarSeccion('gestionarCategorias')"
                    >
                        Gestionar Categorías
                    </li>
                    <li
                        class="cursor-pointer py-2 px-4 rounded-md transition-all duration-300"
                        :class="{'bg-amethyst-8 text-black': seccionSeleccionada === 'gestionarReportajes'}"
                        @click="cambiarSeccion('gestionarReportajes')"
                    >
                        Gestionar Reportajes
                    </li>
                    <li
                        class="cursor-pointer py-2 px-4 rounded-md transition-all duration-300"
                        :class="{'bg-amethyst-8 text-black': seccionSeleccionada === 'gestionarUsuarios'}"
                        @click="cambiarSeccion('gestionarUsuarios')"
                    >
                        Gestionar Usuarios
                    </li>
                </ul>
            </nav>
         </div>


        <!-- Contenido de las secciones -->
        <div class="py-8" v-if="seccionSeleccionada === 'gestionarCategorias'">
            <GestionarCategorias :categorias="categorias"></GestionarCategorias>
        </div>
        <div class="py-12" v-if="seccionSeleccionada === 'gestionarReportajes'">
            <GestionarReportajes :categorias="categorias" :reportajes="reportajes"></GestionarReportajes>
        </div>
        <div class="py-12" v-if="seccionSeleccionada === 'gestionarUsuarios'">
            <GestionarUsuarios :users="users" :roles="roles"></GestionarUsuarios>
        </div>

    </AuthenticatedLayout>
</template>

<style scoped>


/* Efectos de hover y transición */
.cursor-pointer {
    transition: transform 0.3s ease, background-color 0.3s ease;
}

.cursor-pointer:hover {
    transform: scale(1.05);
}

/* Estilo de los elementos de la barra de navegación */
nav ul li {
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 1rem;
}

nav ul li.bg-amethyst-8 {
    background-color: #9b59b6;
}



</style>
