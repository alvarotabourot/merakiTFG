<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { router, useForm } from '@inertiajs/vue3';
import heic2any from 'heic2any';
import ReportajesForm from './ReportajesForm.vue';


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


const showFormNuevaReportaje= ref(false);

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

</script>

<template>
    <Head title="Mis Reportajes" />

    <AuthenticatedLayout>
        <div class="bg-gradient-to-r from-amethyst-3 to-amethyst-6 py-12 text-center">
            <h1 class="text-4xl font-bold text-black">Mis Reportajes</h1>
            <p class="text-lg text-black-200 mt-2">Explora tus propios reportajes</p>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div v-if="props.reportajes.length === 0" class="text-center text-xl text-gray-600">
                    Aún no hay reportajes.
                </div>

                <div v-else class="flex gap-6 m-6">
                    <div v-for="reportaje in props.reportajes" :key="reportaje.id" class="flex flex-col items-center bg-white overflow-hidden shadow-sm sm:rounded-lg p-2">

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

                        <div class="flex gap-4">
                            <div @click="editarReportaje(reportaje)"><font-awesome-icon :icon="['fas', 'pen-to-square']" /></div>
                            <div @click="eliminarReportaje(reportaje)"><font-awesome-icon :icon="['fas', 'trash']" /></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div v-if="showFormNuevaReportaje" class="fixed inset-0 z-50 flex items-center justify-center div-overlay bg-black bg-opacity-50 backdrop-blur-sm" @click="closeDivOnClickOutside">
            <div class="w-[22rem] md:w-[70rem] max-w-lg bg-white rounded-lg shadow-lg">
                <ReportajesForm :reportaje="reportajeEditar" :categorias="props.categorias" @formSubmitted="handleFormSubmitted" @closeForm="toggleFormReportaje"></ReportajesForm>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
