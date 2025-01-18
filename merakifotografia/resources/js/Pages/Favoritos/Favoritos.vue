<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue'; // Importación de funciones de Vue
import InputError from '@/Components/InputError.vue'; // Importación del componente InputError
import InputLabel from '@/Components/InputLabel.vue'; // Importación del componente InputLabel
import { router, useForm } from '@inertiajs/vue3'; // Importación del enrutador y useForm de Inertia
import heic2any from 'heic2any'; // Importación de la librería heic2any para convertir archivos HEIC


const props = defineProps({
    'reportajes' :{
        type: Array,
        default: () => [],
    },

    'categorias' : {
        type: Array,
        default: () => [],
    },
})

const mostrarReporte = (reportajeId) => {
    router.get(route('reportaje.show', reportajeId));
}

</script>

<template>
    <Head title="Mis Favoritos" />

    <AuthenticatedLayout>
        <!-- Encabezado principal -->
        <div class="bg-gradient-to-r from-amethyst-3 to-amethyst-6 py-12 text-center">
            <h1 class="text-4xl font-bold text-black">Mis Favoritos</h1>
            <p class="text-lg text-black-200 mt-2">Explora los reportajes que más te gustan</p>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="props.reportajes.length === 0" class="text-center text-xl text-gray-600">
                    Aún no hay reportajes.
                </div>

                <div v-else class="flex gap-6 m-6">
                    <div v-for="reportaje in props.reportajes" :key="reportaje.id" class="flex flex-col items-center bg-white overflow-hidden shadow-sides2 sm:rounded-lg p-2">

                        <div v-if="reportaje.foto" @click="mostrarReporte(reportaje.id)" class="h-60 w-56 cursor-pointer overflow-hidden bg-black">
                            <img :src="`/imagenes/fotosReportajes/${reportaje.foto}`" alt="portada" class="w-full h-full object-cover"/>
                        </div>
                        <div v-else class="h-60 w-56 overflow-hidden bg-black">
                            <img :src="`/imagenes/fotosReportajes/defaultReportaje.jpg`" alt="portada" class="w-full h-full object-cover"/>
                        </div>
                        <div class="text-center text-lg w-30 truncate ...">{{ reportaje.nombre }}</div>

                        <div v-for="categoria in props.categorias" :key="categoria.id" class="flex gap-4">
                            <div v-if="reportaje.categoria_id === categoria.id" class="text-sm text-gray-600">{{ categoria.nombre }}</div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
