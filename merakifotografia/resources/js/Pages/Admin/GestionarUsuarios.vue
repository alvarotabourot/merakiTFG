<script setup>
import { defineProps, ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },
    roles: {
        type: Array,
        default: () => [],
    },
});

const selectedRole = ref(null);

const eliminarUsuario = (usuarioId) => {
    if (confirm('¿Estás seguro de eliminar el usuario?')) {
        router.delete(route('user.destroy', usuarioId), {
            onSuccess: () => {
                console.log('Usuario eliminado con éxito');
            },
        });
    }
};

// Computed property to filter users
const filteredUsers = computed(() => {
    if (!selectedRole.value) return props.users;
    return props.users.filter(user => user.rol_id === selectedRole.value);
});
</script>

<template>
    <div class="">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Selector de Rol -->
            <div class="mb-6 flex justify-center">
                <select
                    v-model="selectedRole"
                    class="block w-1/2 p-3 bg-white border border-gray-300 rounded-lg shadow-sm focus:ring-purple-500 focus:border-purple-500 transition duration-300"
                >
                    <option :value="null">Todos los roles</option>
                    <option v-for="role in props.roles" :key="role.id" :value="role.id">
                        {{ role.rol }}
                    </option>
                </select>
            </div>

            <!-- Mostrar mensaje si no hay usuarios -->
            <div v-if="!filteredUsers.length" class="text-center text-xl text-gray-600">
                No se encontraron usuarios para este rol.
            </div>

            <!-- Grid de Usuarios -->
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <div
                    v-for="user in filteredUsers"
                    :key="user.id"
                    class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300"
                >
                    <!-- Información del usuario -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 text-center truncate mb-2">
                            {{ user.nombre }}
                        </h3>

                        <!-- Rol del usuario -->
                        <div v-for="role in props.roles" :key="role.id" class="text-sm text-purple-600 text-center">
                            <div v-if="user.rol_id === role.id">{{ role.rol }}</div>
                        </div>

                        <!-- Botón eliminar -->
                        <div class="mt-4 flex justify-center gap-4">
                            <button
                                @click="eliminarUsuario(user.id)"
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

.hover\:shadow-xl:hover {
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
}

.bg-white {
    background-color: #fff;
}
</style>
