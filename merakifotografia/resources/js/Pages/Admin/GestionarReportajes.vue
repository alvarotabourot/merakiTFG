<script setup>
import { defineProps, ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    reportajes: {
        type: Array,
        default: () => [],
    },
    categorias: {
        type: Array,
        default: () => [],
    },
});

const selectedCategory = ref(null);

const filteredReportajes = computed(() => {
    if (!selectedCategory.value) return props.reportajes;
    return props.reportajes.filter(reportaje => reportaje.categoria_id === selectedCategory.value);
});

const eliminarReportaje = (reportaje) => {
    if (confirm('¿Estás seguro de eliminar el reportaje?')) {
        router.delete(route('reportaje.destroy', reportaje), {
            onSuccess: () => {
                console.log('Reportaje eliminado con éxito');
            },
        });
    }
};

const mostrarReporte = (reportajeId) => {
    router.get(route('reportaje.show', reportajeId));
};
</script>

<template>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filtro por categoría -->
            <div class="mb-8 flex justify-center">
                <select
                    v-model="selectedCategory"
                    class="block w-1/2 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                >
                    <option :value="null">Todas las categorías</option>
                    <option v-for="categoria in props.categorias" :key="categoria.id" :value="categoria.id">
                        {{ categoria.nombre }}
                    </option>
                </select>
            </div>

            <!-- Mensaje si no hay reportajes -->
            <div v-if="!filteredReportajes.length" class="text-center text-xl text-gray-600">
                No se encontraron reportajes para esta categoría.
            </div>

            <!-- Grid de reportajes -->
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div
                    v-for="reportaje in filteredReportajes"
                    :key="reportaje.id"
                    class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300"
                >
                    <!-- Imagen del reportaje -->
                    <div
                        v-if="reportaje.foto"
                        @click="mostrarReporte(reportaje.id)"
                        class="cursor-pointer h-52 bg-gray-200 overflow-hidden"
                    >
                        <img
                            :src="`/imagenes/fotosReportajes/${reportaje.foto}`"
                            alt="portada"
                            class="w-full h-full object-cover transition duration-300 hover:scale-105"
                        />
                    </div>
                    <div
                        v-else
                        class="cursor-pointer h-52 bg-gray-200 overflow-hidden"
                        @click="mostrarReporte(reportaje.id)"
                    >
                        <img
                            src="/imagenes/fotosReportajes/defaultReportaje.jpg"
                            alt="portada predeterminada"
                            class="w-full h-full object-cover"
                        />
                    </div>

                    <!-- Información del reportaje -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 truncate mb-2 text-center">
                            {{ reportaje.nombre }}
                        </h3>
                        <div
                            v-for="categoria in props.categorias"
                            :key="categoria.id"

                        >
                        <p v-if="reportaje.categoria_id === categoria.id"
                        class="text-sm text-purple-600 text-center">
                            {{ categoria.nombre }}
                        </p>

                        </div>
                        <div class="mt-4 flex justify-center gap-4">
                            <button
                                @click="eliminarReportaje(reportaje)"
                                class="text-red-600 hover:text-red-800 transition duration-300"
                            >
                                <font-awesome-icon :icon="['fas', 'trash']" class="text-xl" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Estilo adicional para personalización */
.select {
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.hover\:scale-105:hover {
    transform: scale(1.05);
}

.hover\:shadow-xl:hover {
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
}
</style>
