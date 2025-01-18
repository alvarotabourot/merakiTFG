<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import CategoriaForm from '../Categoria/CategoriaForm.vue';

const seccionSeleccionada = ref('gestionarCategorias');
const showFormNuevaCategoria = ref(false);
const categoriaEditar = ref(null);

const props = defineProps({
    categorias: {
        type: Array,
        default: () => [],
    },
});

const toggleFormCategoria = () => {
    showFormNuevaCategoria.value = !showFormNuevaCategoria.value;
    if (!showFormNuevaCategoria.value) {
        categoriaEditar.value = null;
    }
};

const editarCategoria = (categoria) => {
    categoriaEditar.value = categoria;
    showFormNuevaCategoria.value = true;
};

const handleFormSubmitted = () => {
    showFormNuevaCategoria.value = false;
    categoriaEditar.value = null;
};

const eliminarCategoria = (categoriaId) => {
    if (confirm('¿Estás seguro de eliminar la categoría?')) {
        router.delete(route('categoria.destroy', categoriaId), {
            onSuccess: () => {
                console.log('Categoría eliminada con éxito');
            },
        });
    }
};
</script>

<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Botón Añadir Categoría -->
        <div class="flex justify-end mb-6">
            <button
                class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 mr-3 rounded-lg shadow-md transition duration-300"
                @click="toggleFormCategoria"
            >
                Añadir Categoría
            </button>
        </div>

        <!-- Listado de Categorías -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div
                v-for="categoria in categorias"
                :key="categoria.id"
                class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition duration-300"
            >
                <!-- Imagen de Categoría -->
                <div class="h-44 bg-gray-200 overflow-hidden">
                    <img
                        v-if="categoria.foto"
                        :src="`/imagenes/fotosCategorias/${categoria.foto}`"
                        alt="portada"
                        class="w-full h-full object-cover"
                    />
                    <img
                        v-else
                        src="/imagenes/fotosCategorias/default.jpg"
                        alt="portada predeterminada"
                        class="w-full h-full object-cover"
                    />
                </div>

                <!-- Nombre y Opciones -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800 truncate text-center">
                        {{ categoria.nombre }}
                    </h3>
                    <div class="flex justify-center gap-4 mt-4">
                        <button
                            class="text-blue-600 hover:text-blue-800"
                            @click="editarCategoria(categoria)"
                        >
                            <font-awesome-icon :icon="['fas', 'pen-to-square']" class="text-xl" />
                        </button>
                        <button
                            class="text-red-600 hover:text-red-800"
                            @click="eliminarCategoria(categoria.id)"
                        >
                            <font-awesome-icon :icon="['fas', 'trash']" class="text-xl" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Categoría -->
    <div v-if="showFormNuevaCategoria" @click="toggleFormCategoria" class="fixed inset-0 z-50 flex items-center justify-center div-overlay bg-black bg-opacity-50 backdrop-blur-sm">
        <div class="w-[22rem] md:w-[70rem] max-w-lg  rounded-lg shadow-lg" @click.stop>
            <CategoriaForm :categoria="categoriaEditar ? categoriaEditar : ''" @formSubmitted="handleFormSubmitted" @closeForm="toggleFormCategoria"></CategoriaForm>
        </div>
    </div>
</template>

<style scoped>
/* Estilos adicionales */
.bg-purple-600 {
    background-color: #6b46c1;
}
.bg-purple-700 {
    background-color: #5a3aaa;
}
.hover\:bg-purple-700:hover {
    background-color: #5a3aaa;
}
.shadow-md {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.hover\:shadow-lg:hover {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
}
</style>
