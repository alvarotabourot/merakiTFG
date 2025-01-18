<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue'; // Importación de funciones de Vue
import { router } from '@inertiajs/vue3'; // Importación del enrutador de Inertia

const props = defineProps({
    reportajes: {
        type: Array,
        default: () => [],
    },
    categorias: {
        type: Array,
        default: () => [],
    },
    categoria: {
        type: Object,
        default: () => {},
    },
});

const mostrarReporte = (reportajeId) => {
    router.get(route('reportaje.show', reportajeId));
};
</script>

<template>
    <Head :title="props.categoria.nombre" />

    <AuthenticatedLayout>
        <!-- Banner con la foto de la categoría -->
        <div
            class="relative w-full h-72 bg-gradient-to-b from-amethyst-1 via-amethyst-8 to-amethyst-1"
        >
            <img
                :src="`/imagenes/fotosCategorias/${props.categoria.foto}`"
                alt="portada"
                class="absolute inset-0 w-full h-full object-cover opacity-50"
            />
            <div class="relative z-10 flex flex-col items-center justify-center h-full text-white">
                <h1 class="text-4xl font-bold mb-4">{{ props.categoria.nombre }}</h1>
                <p class="text-lg font-semibold">Explora los reportajes destacados</p>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="py-12 bg-gray-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Mensaje si no hay reportajes -->
                <div
                    v-if="props.reportajes.length === 0"
                    class="text-center text-xl text-gray-600 py-12"
                >
                    Aún no hay reportajes disponibles.
                </div>

                <!-- Grid de reportajes -->
                <div
                    v-else
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
                >
                    <div
                        v-for="reportaje in props.reportajes"
                        :key="reportaje.id"
                        class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300"
                    >
                        <!-- Imagen del reportaje -->
                        <div
                            v-if="reportaje.foto"
                            @click="mostrarReporte(reportaje.id)"
                            class="cursor-pointer h-48 overflow-hidden"
                        >
                            <img
                                :src="`/imagenes/fotosReportajes/${reportaje.foto}`"
                                alt="portada"
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
                            />
                        </div>
                        <div v-else class="h-48 bg-gray-200 flex items-center justify-center">
                            <span class="text-gray-500">Sin imagen</span>
                        </div>

                        <!-- Detalles del reportaje -->
                        <div class="p-4 text-center">
                            <h3
                                class="text-lg font-semibold text-gray-800 truncate"
                            >
                                {{ reportaje.nombre }}
                            </h3>
                            <div v-for="categoria in props.categorias" :key="categoria.id">
                                <span
                                    v-if="reportaje.categoria_id === categoria.id"
                                    class="text-sm text-amethyst-8"
                                >
                                    {{ categoria.nombre }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/**** Animaciones y ajustes visuales ****/
html {
    scroll-behavior: smooth;
}
</style>
