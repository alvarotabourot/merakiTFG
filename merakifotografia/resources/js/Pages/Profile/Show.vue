<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue'; // Importación de funciones de Vue
import { router } from '@inertiajs/vue3'; // Importación del enrutador de Inertia

const props = defineProps({
    profile: {
        type: Object,
        default: () => ({}),
    },
    auth: Object,
});

const mostrarReporte = (reportajeId) => {
    router.get(route('reportaje.show', reportajeId));
};

const scrollToContactForm = () => {
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.scrollIntoView({ behavior: 'smooth' });
    }
};

const form = ref({
    name: '',
    email: '',
    message: '',
    photographer_email: props.profile.email,
});

const submitForm = () => {
    router.post(route('contact.photographer'), form.value, {
        onSuccess: () => {
            alert('¡Tu mensaje ha sido enviado!');
            form.value.name = '';
            form.value.email = '';
            form.value.message = '';
        },
    });
};
</script>

<template>
    <Head :title="props.profile.nombre" />

    <AuthenticatedLayout>
        <div class="py-12">
            <!-- Foto de perfil e información -->
            <div class="flex flex-col items-center pb-6 mb-4 border-b border-gray-700 max-w-4xl mx-auto">
                <div class="relative w-40 h-40">
                    <img
                        v-if="props.profile.foto"
                        :src="`/imagenes/fotosUsuarios/${props.profile.foto}`"
                        alt="Foto de perfil"
                        class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-purple-600"
                    />
                    <img
                        v-else
                        src="/imagenes/fotosUsuarios/defaultProfile.jpg"
                        alt="Foto de perfil predeterminada"
                        class="w-40 h-40 rounded-full object-cover shadow-lg border-4 border-purple-600"
                    />
                </div>
                <h1 class="text-3xl font-semibold text-gray-800 mt-4">
                    {{ props.profile.nombre }} {{ props.profile.apellidos }}
                </h1>
                <p class="text-lg text-gray-500">@{{ props.profile.usuario }}</p>
                <p class="text-md text-gray-600 italic mt-2">{{ props.profile.descripcion }}</p>
                <button
                    v-if="props.auth?.user?.id !== props.profile.id"
                    @click="scrollToContactForm"
                    class="mt-4 px-6 py-2 bg-purple-600 text-white rounded-lg shadow-md hover:bg-purple-700 transition"
                >
                    Contactar
                </button>

                <button v-else class="mt-4 px-6 py-2 bg-purple-600 text-white rounded-lg shadow-md hover:bg-purple-700 transition">
                   <a :href="route('profile.edit')" class="text-white">Editar Perfil</a>

                </button>



            </div>

            <!-- Lista de reportajes -->
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div v-if="props.profile.reportajes.length === 0" class="text-center text-xl text-gray-600">
                    Aún no hay reportajes.
                </div>

                <div v-else>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Reportajes</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        <div
                            v-for="reportaje in props.profile.reportajes"
                            :key="reportaje.id"
                            class="bg-white overflow-hidden shadow-md rounded-lg transition-transform transform hover:scale-105 hover:shadow-xl"
                        >
                            <div
                                v-if="reportaje.foto"
                                @click="mostrarReporte(reportaje.id)"
                                class="h-56 cursor-pointer overflow-hidden rounded-t-lg"
                            >
                                <img
                                    :src="`/imagenes/fotosReportajes/${reportaje.foto}`"
                                    alt="Portada"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div v-else class="h-56 overflow-hidden rounded-t-lg bg-gray-200">
                                <img
                                    :src="`/imagenes/fotosReportajes/defaultReportaje.jpg`"
                                    alt="Portada predeterminada"
                                    class="w-full h-full object-cover"
                                />
                            </div>
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-gray-800 truncate">
                                    {{ reportaje.nombre }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario de contacto -->
            <div v-if="props.auth?.user?.id !== props.profile.id" id="contact-form" class="mt-12 max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contáctame</h2>
                <form @submit.prevent="submitForm">
                    <input type="hidden" v-model="form.photographer_email" />
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input
                            id="name"
                            type="text"
                            v-model="form.name"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <input
                            id="email"
                            type="email"
                            v-model="form.email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500"
                        />
                    </div>
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700">Mensaje</label>
                        <textarea
                            id="message"
                            rows="5"
                            v-model="form.message"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-purple-500 focus:border-purple-500"
                        ></textarea>
                    </div>
                    <button
                        type="submit"
                        class="w-full py-2 px-4 bg-purple-600 text-white font-semibold rounded-md shadow-md hover:bg-purple-700 focus:ring focus:ring-purple-300"
                    >
                        Enviar mensaje
                    </button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Estilo adicional para los componentes */
.shadow-lg {
    box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1), 0px 4px 6px -2px rgba(0, 0, 0, 0.05);
}
.shadow-xl {
    box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.1), 0px 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>
