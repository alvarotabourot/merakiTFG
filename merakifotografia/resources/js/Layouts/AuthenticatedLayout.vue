<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3'; // Import usePage
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import ReportajesForm from '@/Pages/Reportajes/ReportajesForm.vue';

const showingNavigationDropdown = ref(false);
const howRegister = ref(false);
const mobileMenuOpen = ref(false);

const { props } = usePage(); // Destructuring usePage to get props

const categorias = ref(props.categorias);
const showFormReportaje = ref(false);

const toggleFormReportaje = () => {
  showFormReportaje.value = !showFormReportaje.value;
};

const toggleModal = () => {
  howRegister.value = !howRegister.value;
};

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value;
};

const handleFormSubmittedReportaje = () => {
  showFormReportaje.value = false;
};

const closeDivOnClickOutside = (event) => {
  if (event.target.classList.contains('div-overlay')) {
    showFormReportaje.value = false;
    howRegister.value = false;
    mobileMenuOpen.value = false;
  }
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-200 shadow-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20 items-center ">
                        <!-- Logo -->
                        <div class="flex items-center">
                            <Link :href="route('welcome')">
                                <ApplicationLogo class="block h-36	 w-auto fill-current text-gray-800" />
                            </Link>
                        </div>

                        <!-- Desktop Menu -->
                        <div class="hidden md:flex space-x-6 items-center">
                            <NavLink :href="route('welcome')" :active="route().current('welcome')" class="text-purple-600 hover:text-purple-800">
                                Inicio
                            </NavLink>
                            <NavLink :href="route('categorias')" :active="route().current('categorias')" class="text-purple-600 hover:text-purple-800">
                                Categorías
                            </NavLink>
                            <NavLink v-if="props.auth?.user" :href="route('mis_favoritos')" :active="route().current('mis_favoritos')" class="text-purple-600 hover:text-purple-800">
                                Mis Favoritos
                            </NavLink>
                            <NavLink v-if="props.auth.user?.rol_id === 1" :href="route('paneldeadministrador')" :active="route().current('paneldeadministrador')" class="text-purple-600 hover:text-purple-800">
                                Panel de Administrador
                            </NavLink>
                            <NavLink v-if="props.auth.user?.rol_id === 2" :href="route('mis_reportajes')" :active="route().current('mis_reportajes')" class="text-purple-600 hover:text-purple-800">
                                Mis Reportajes
                            </NavLink>

                            <NavLink
                                v-if="props.auth.user?.rol_id === 2"
                                :href="route('user.show', props.auth.user.id)"
                                :active="route().current('user.show')"
                                class="text-purple-600 hover:text-purple-800"
                            >
                                Perfil
                            </NavLink>


                            <!-- Profile and Logout for authenticated users -->
                            <NavLink v-if="props.auth.user" :href="route('profile.edit')" class="text-purple-600 text-[16px] hover:text-purple-800">
                                <font-awesome-icon :icon="['fas', 'user-gear']" />
                            </NavLink>

                            <NavLink v-if="props.auth.user" :href="route('logout')" method="post" as="button" class="text-red-600 text-[16px] hover:text-red-800">
                                <font-awesome-icon :icon="['fas', 'right-from-bracket']" />
                            </NavLink>

                            <div v-if="!props.auth.user" class="flex space-x-4 ml-auto">
                                <Link :href="route('login')" class="rounded-full px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white">
                                    Log in
                                </Link>
                                <button @click="toggleModal" class="rounded-full px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white">
                                    Register
                                </button>
                            </div>
                        </div>

                        <!-- Mobile Menu Button -->
                        <div class="md:hidden flex items-center">
                            <button @click="toggleMobileMenu" class="text-purple-600 hover:text-purple-800 focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div v-if="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-200 shadow-lg">
                    <div class="pt-4 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('welcome')" :active="route().current('welcome')" class="text-purple-600 hover:text-purple-800">
                            Inicio
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('categorias')" :active="route().current('categorias')" class="text-purple-600 hover:text-purple-800">
                            Categorías
                        </ResponsiveNavLink>
                        <ResponsiveNavLink v-if="props.auth?.user" :href="route('mis_favoritos')" :active="route().current('mis_favoritos')" class="text-purple-600 hover:text-purple-800">
                            Mis Favoritos
                        </ResponsiveNavLink>
                        <ResponsiveNavLink v-if="props.auth.user?.rol_id === 1" :href="route('paneldeadministrador')" :active="route().current('paneldeadministrador')" class="text-purple-600 hover:text-purple-800">
                            Panel de Administrador
                        </ResponsiveNavLink>
                        <ResponsiveNavLink v-if="props.auth.user?.rol_id === 2" :href="route('mis_reportajes')" :active="route().current('mis_reportajes')" class="text-purple-600 hover:text-purple-800">
                            Mis Reportajes
                        </ResponsiveNavLink>

                        <ResponsiveNavLink
                            v-if="props.auth.user?.rol_id === 2"
                            :href="route('user.show', props.auth.user.id)"
                            :active="route().current('user.show')"
                            class="text-purple-600 hover:text-purple-800"
                        >
                            Perfil
                        </ResponsiveNavLink>


                        <!-- Profile and Logout for authenticated users -->
                         <div class="flex ">
                            <ResponsiveNavLink v-if="props.auth.user" :href="route('profile.edit')" class="text-purple-600 text-[16px] w-12 hover:text-purple-800">
                                <font-awesome-icon :icon="['fas', 'user-gear']" />
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="props.auth.user" :href="route('logout')" method="post" as="button" class="text-red-600 text-[16px] w-12 hover:text-red-800">
                                <font-awesome-icon :icon="['fas', 'right-from-bracket']" />
                            </ResponsiveNavLink>
                         </div>


                        <div v-if="!props.auth.user" class="space-y-1">
                            <Link :href="route('login')" class="block text-center py-2 text-purple-600 hover:bg-purple-100">Log in</Link>
                            <button @click="toggleModal" class="block w-full text-center py-2 text-purple-600 hover:bg-purple-100">Register</button>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Formulario de Reportaje -->
            <div v-if="showFormReportaje" class="fixed inset-0 z-50 flex items-center justify-center div-overlay bg-black bg-opacity-50 backdrop-filter backdrop-blur-sm" @click="closeDivOnClickOutside">
                <div class="w-[22rem] md:w-[70rem] max-w-lg bg-white rounded-lg shadow-lg">
                    <ReportajesForm :categorias="categorias" @formSubmitted="handleFormSubmittedReportaje" @closeForm="toggleFormReportaje"></ReportajesForm>
                </div>
            </div>

            <button
                v-else-if="props.auth.user?.rol_id === 2"
                class="fixed bottom-5 right-5 bg-green-600 text-white rounded-full z-10 p-4 shadow-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-blue-300"
                @click="toggleFormReportaje"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>

            <div v-if="howRegister && !props.auth.user" class="fixed inset-0 z-50  flex items-center justify-center bg-black bg-opacity-50 div-overlay" @click="closeDivOnClickOutside">
                <div class="max-w-lg w-full bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-semibold text-center mb-4">¡Bienvenido! ¿Como te gustaría registrarte?</h2>
                    <div class="flex flex-col gap-4">
                        <Link :href="route('register')" class="btn flex items-center justify-center gap-2 bg-purple-500 hover:bg-purple-600 text-white text-xl font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                            <font-awesome-icon :icon="['fas', 'fa-user-circle']" />
                            Usuario
                        </Link>
                        <Link :href="route('registerFotografo')" class="btn flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-xl text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105">
                            <font-awesome-icon :icon="['fas', 'fa-camera-retro']" />
                            Fotógrafo
                        </Link>
                    </div>
                </div>
            </div>


            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>

</style>
