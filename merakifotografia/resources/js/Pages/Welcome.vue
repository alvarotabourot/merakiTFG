<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const howRegister = ref(false);

const toggleModal = () => {
    howRegister.value = !howRegister.value;
}

const closeDivOnClickOutside = (event) => {
  if (event.target.classList.contains('div-overlay')) {
    howRegister.value = false;
  }
}

defineProps({
    canLogin: { type: Boolean },
    canRegister: { type: Boolean },
    laravelVersion: { type: String, required: true },
    phpVersion: { type: String, required: true },
    categorias: { type: Array, required: true },
    reportajesMasGustados: { type: Array, required: true }
});
</script>

<template>
    <Head title="Inicio" />
    <AuthenticatedLayout :can-login="canLogin" :can-register="canRegister">
        <template #default>
            <!-- Hero Section -->
            <div class="relative bg-gradient-to-r from-amethyst-3 to-amethyst-6 text-white py-20">
                <div class="max-w-7xl mx-auto px-6 text-center">
                    <h1 class="text-5xl text-black font-extrabold mb-4">Bienvenidos a MERAKI</h1>
                    <p class="text-lg text-black font-light mb-8">La esencia de ti mismo, reflejada en lo que haces.</p>
                    <Link :href="route('categorias')" class="btn bg-white text-purple-800 font-bold">Explorar Categorías</Link>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-gray-50 text-black ">
                <main class="max-w-7xl mx-auto p-6 space-y-16">
                    <!-- About Section -->
                    <section id="about" class="text-center py-12">
                        <h2 class="text-4xl font-bold text-gray-800  mb-4">Sobre Nosotros</h2>
                        <p class="text-lg text-gray-600  max-w-4xl mx-auto">En Meraki queremos que tu pasion y tu entrega se muestren a todo el mundo. Por eso creemos que si estas buscando darte a conocer este es tu lugar. Sino sabes a quien elegir para mostrar la esencia de tus momentos importantes, aquí podrás encontrar quienes lo hagan.</p>
                    </section>

                    <!-- Categorías Destacadas -->
                    <section id="categorias">
                        <h2 class="text-4xl font-bold text-gray-800  mb-6">Categorías Destacadas</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <div v-for="categoria in categorias" :key="categoria.id" class="bg-white rounded-lg shadow-md hover:shadow-lg transition cursor-pointer">
                                <Link :href="route('categoria.show', categoria.id)" class="block">
                                    <div class="relative h-48 w-full overflow-hidden rounded-t-lg">
                                        <img :src="categoria.foto ? `/imagenes/fotosCategorias/${categoria.foto}` : '/imagenes/fotosCategorias/defaultCategoria.jpg'" alt="{{ categoria.nombre }}" class="object-cover w-full h-full" />
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-2xl font-medium text-black">{{ categoria.nombre }}</h3>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </section>

                    <!-- Reportajes Más Gustados -->
                    <section id="reportajes">
                        <h2 class="text-4xl font-bold text-gray-800  mb-6">Reportajes Más Gustados</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            <div v-for="reportaje in reportajesMasGustados" :key="reportaje.id" class="bg-white rounded-lg shadow-md hover:shadow-lg transition cursor-pointer">
                                <Link :href="route('reportaje.show', reportaje.id)" class="block">
                                    <div class="relative h-48 w-full overflow-hidden rounded-t-lg">
                                        <img :src="reportaje.foto ? `/imagenes/fotosReportajes/${reportaje.foto}` : '/imagenes/fotosReportajes/defaultReportaje.jpg'" alt="{{ reportaje.nombre }}" class="object-cover w-full h-full" />
                                    </div>
                                    <div class="p-4">
                                        <h3 class="text-2xl font-medium text-black">{{ reportaje.nombre }}</h3>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </section>

                    <!-- Call to Action -->
                    <section class="bg-gradient-to-r from-amethyst-3 to-amethyst-6 text-white py-16 text-center">
                        <h2 class="text-4xl text-black font-bold mb-4">Únete a Nuestra Comunidad</h2>
                        <p class="text-lg text-black font-light mb-8">Comparte tus mejores fotografías y reportajes con el mundo. Inspira y deja que otros se inspiren contigo.</p>
                        <Link :route="route('register')" class="btn bg-white text-purple-800 font-bold">Regístrate Ahora</Link>
                    </section>
                </main>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<style scoped>
.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    margin: 5px;
    border-radius: 6px;
    background-color: #D7BDE2;
    color: black;
    text-align: center;
    font-weight: medium;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #76448A;
    color: white;
}
</style>
