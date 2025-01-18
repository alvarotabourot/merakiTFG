<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    categorias: {
        type: Array,
        default: () => [],
    },
});

const mostrarCategoria = (categoriaId) => {
    router.get(route('categoria.show', categoriaId));
};
</script>

<template>
    <Head title="Categorías" />

    <AuthenticatedLayout>
        <!-- Encabezado principal -->
        <div class="bg-gradient-to-r from-amethyst-3 to-amethyst-6 py-12 text-center">
            <h1 class="text-4xl font-bold text-black">Explora las Categorías</h1>
            <p class="text-lg text-black-200 mt-2">Encuentra el contenido que más te interesa</p>
        </div>

        <!-- Contenido principal -->
        <div class="py-12 bg-gray-100">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Mensaje si no hay categorías -->
                <div v-if="props.categorias.length === 0" class="text-center text-xl text-gray-600 py-12">
                    Aún no hay categorías disponibles.
                </div>

                <!-- Grid de categorías -->
                <div
                    v-else
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
                >
                    <div
                        v-for="categoria in props.categorias"
                        :key="categoria.id"
                        class="relative bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300 cursor-pointer"
                        @click="mostrarCategoria(categoria.id)"
                    >
                        <!-- Imagen de la categoría -->
                        <div class="h-48 overflow-hidden">
                            <img
                                :src="categoria.foto ? `/imagenes/fotosCategorias/${categoria.foto}` : '/imagenes/fotosReportajes/defaultCategoria.jpg'"
                                alt="Imagen de categoría"
                                class="w-full h-full object-cover hover:scale-110 transition-transform duration-300"
                            />
                        </div>

                        <!-- Detalles de la categoría -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-70"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <h3 class="text-lg font-semibold truncate">{{ categoria.nombre }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/**** Ajustes y animaciones ****/
html {
    scroll-behavior: smooth;
}
</style>
