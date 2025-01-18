<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue'; // Importación de funciones de Vue
import InputError from '@/Components/InputError.vue'; // Importación del componente InputError
import InputLabel from '@/Components/InputLabel.vue'; // Importación del componente InputLabel
import { router, useForm } from '@inertiajs/vue3'; // Importación del enrutador y useForm de Inertia
import heic2any from 'heic2any'; // Importación de la librería heic2any para convertir archivos HEIC
import ReportajesForm from './ReportajesForm.vue';

// Definición de props esperados por el componente
const props = defineProps({
    reportaje: Object,
    categorias: Array,
    auth: Object,
    isFavorito: Boolean,
    favoritosCount: Number, // Número total de favoritos
});


const showFormNuevaReportaje= ref(false); // Variable reactiva para mostrar/ocultar el formulario de tarea

const reportajeEditar = ref(null);

const toggleFormReportaje = () => {
    showFormNuevaReportaje.value = !showFormNuevaReportaje.value;

    if(!showFormNuevaReportaje.value){
        reportajeEditar.value = null;
    }

}

const editarReportaje = (reportaje) => {
    reportajeEditar.value = reportaje;
    showFormNuevaReportaje.value = true;
}

const closeDivOnClickOutside = (event) => {
  if (event.target.classList.contains('div-overlay')) {
    showFormNuevaReportaje.value = false;
  }

}

const handleFormSubmitted = () => {
    showFormNuevaReportaje.value = false;
  reportajeEditar.value = null;
}

const eliminarReportaje = (reportaje) => {
    if (confirm('¿Estás seguro de eliminar la categoría?')) {
        router.delete(route('reportaje.destroy', reportaje), {
            'onSuccess': () => {
                console.log('Reportaje eliminada con éxito');
                },
        })
    }
}

const mostrarReporte = (reportajeId) => {
    router.get(route('reportaje.show', reportajeId));
}

const mostrarFotografo = (fotografoId) => {
    router.get(route('user.show', fotografoId));
}
const toggleFavorito = (reportaje) => {
    if (props.isFavorito) {
        quitarFavorito(reportaje);
    } else {
        agregarFavorito(reportaje);
    }
}

const quitarFavorito = (reportaje) => {
    // Lógica para quitar de favoritos
    router.delete(route('favorito.destroy', reportaje.id), {
        onSuccess: () => {
            // Posiblemente actualices aquí el estado o realices alguna acción
        }
    });
}

const quitarFavoritos = (reportaje) => {
    // Lógica para quitar de favoritos
    router.delete(route('favorito.destroy', reportaje.id), {
        onSuccess: () => {
            // Posiblemente actualices aquí el estado o realices alguna acción
        }
    });
}

const agregarFavorito = (reportaje) => {
    router.post(route('favorito.store', reportaje.id));
}

const goBack = () => {
    window.history.back();
};

</script>


<template>
    <AuthenticatedLayout>

        <div class=" flex justify-end mb-4 m-4">
            <button @click="goBack" class="flex items-center text-gray-600 hover:text-gray-900 focus:outline-none">
                <font-awesome-icon :icon="['fas', 'arrow-left']" class="mr-2" />
                <span class="text-sm">Volver</span>
            </button>
        </div>

        <div class="max-w-5xl mx-auto sm:px-4 lg:px-5">
            <div class="bg-white overflow-hidden  sm:rounded-lg shadow-sides">
                <div class="p-6 text-gray-900">

                    <img :src="`/imagenes/fotosReportajes/${reportaje.foto}`" alt="portada" class="w-full h-96 object-contain bg-black mx-auto"/>                    <h2 class="text-3xl text-black-500 font-mono font-bold text-center mb-4 mt-10 uppercase">{{ reportaje.nombre }}</h2>
                    <p class="text-center text-n text-gray-400 mb-4 text-2xl">Descripción: {{ reportaje.descripcion }}</p>
                    <p class="text-center text-n text-gray-400 mb-4">Fecha: {{ reportaje.fecha }}</p>
                    <p @click="mostrarFotografo(reportaje.fotografo.id)" class="text-center text-n text-black-300 hover:text-black-500 cursor-pointer mb-4 underline">
                        Fotógrafo: {{ reportaje.fotografo.nombre }}
                    </p>
                    <div v-if="props.auth?.user && reportaje.fotografo && props.auth.user.id === reportaje.fotografo.id" class="flex gap-4 justify-end">
                        <button @click='editarReportaje(reportaje)' class="flex gap-2 p-2 px-3 rounded-lg bg-yellow-400 items-center text-gray-900 focus:outline-none">
                            <font-awesome-icon :icon="['fas', 'pen-to-square']" class="fa-1x" />
                            <span class="text-sm">Editar</span>
                        </button>
                        <button @click='eliminarReportaje(reportaje)' class="flex gap-2 p-2 px-3 rounded-lg bg-red-400 items-center text-gray-900 focus:outline-none">
                            <font-awesome-icon :icon="['fas', 'trash']" class="fa-1x"/>
                            <span class="text-sm">Borrar</span>
                        </button>
                    </div>

                    <div v-else-if="props.auth?.user" class="flex gap-3 justify-end items-center p-3">
                        <span class="text-gray-600 font-medium text-xl">{{ favoritosCount }}</span>
                        <button
                            @click="toggleFavorito(reportaje)"
                            class="flex items-center gap-2 p-2 rounded-full bg-gray-100 shadow-md hover:shadow-lg transition-transform transform hover:scale-105 focus:outline-none"
                        >
                            <font-awesome-icon
                                :icon="['fas', 'heart']"
                                :class="{ 'text-red-500': isFavorito, 'text-gray-300': !isFavorito }"
                                class="fa-lg"
                            />
                        </button>
                    </div>



                </div>
            </div>

            <div v-if="reportaje.fotos.length > 0" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-9">
                <div class="bg-white overflow-hidden shadow-sides sm:rounded-lg ">
                    <h2 class="text-3xl text-black-500 font-mono font-bold text-center mt-5">Fotos</h2>
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-6 text-gray-900">
                        <div v-for="foto in reportaje.fotos" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow-xl hover:shadow-sides2 sm:rounded-lg">
                                <div class="p-3 text-gray-900">
                                    <a :href="`/imagenes/fotosReportajes/${foto.url}`" target="_blank">
                                        <!-- Ajusta el ancho y la altura -->
                                        <img :src="`/imagenes/fotosReportajes/${foto.url}`" alt="portada" class="w-full h-48 object-cover"/>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sides mt-4">
                    <p class="text-center text-n text-black-400 p-4">No hay fotos para este reporte</p>
                </div>
            </div>
        </div>

        <div class=" flex justify-center mb-2 m-4">
            <button @click="goBack" class="flex items-center text-gray-600 hover:text-gray-900 focus:outline-none">
                <font-awesome-icon :icon="['fas', 'arrow-left']" class="mr-2" />
                <span class="text-sm">Volver</span>
            </button>
        </div>

        <div v-if="showFormNuevaReportaje" class="fixed inset-0 z-50 flex items-center justify-center div-overlay bg-black bg-opacity-50 backdrop-blur-sm" @click="closeDivOnClickOutside">
            <div class="w-[22rem] md:w-[70rem] max-w-lg  bg-white rounded-lg shadow-lg">
                <ReportajesForm  :reportaje="reportajeEditar" :categorias="props.categorias"  @formSubmitted="handleFormSubmitted" @closeForm="toggleFormReportaje"></ReportajesForm>
            </div>
        </div>



        </AuthenticatedLayout>
</template>
