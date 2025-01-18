<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const volverInicio = () => {
    window.location.href = '/'; // Redirige al usuario a la página principal
};
</script>

<template>
    <Head title="Página no encontrada" />

    <AuthenticatedLayout>
        <div class="h-screen w-full flex flex-col items-center justify-center bg-gradient-to-r from-purple-300 via-purple-400 to-purple-500 text-white">
            <!-- Icono de error -->
            <div class="text-8xl font-bold mb-4 animate-pulse">404</div>

            <!-- Mensaje de error -->
            <h1 class="text-4xl font-semibold mb-2">¡Oops! Página no encontrada</h1>
            <p class="text-lg mb-6 text-gray-200">
                La página que buscas no está disponible o fue movida.
            </p>

            <!-- Botón de regreso -->
            <button
                @click="volverInicio"
                class="px-6 py-3 bg-white text-purple-700 font-semibold rounded-lg shadow-lg hover:bg-gray-200 transition-all duration-300"
            >
                Volver al Inicio
            </button>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Fondo animado */
body {
    background: linear-gradient(90deg, rgba(136, 2, 246, 1) 0%, rgba(211, 2, 194, 1) 100%);
    animation: gradient 6s ease infinite;
    background-size: 400% 400%;
}

@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Animación del texto */
.animate-pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.8;
    }
}
</style>
