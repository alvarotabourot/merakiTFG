<script setup>
import { ref, watch } from 'vue'; // Importación de ref y watch desde Vue 3
import InputError from '@/Components/InputError.vue'; // Importación del componente InputError
import InputLabel from '@/Components/InputLabel.vue'; // Importación del componente InputLabel
import PrimaryButton from '@/Components/PrimaryButton.vue'; // Importación del componente PrimaryButton
import TextInput from '@/Components/TextInput.vue'; // Importación del componente TextInput
import { useForm } from '@inertiajs/vue3'; // Importación de useForm desde Inertia.js
import { defineProps, defineEmits } from 'vue'; // Importación de defineProps y defineEmits desde Vue 3
import heic2any from 'heic2any'; // Importación de la librería heic2any para convertir archivos HEIC

// Definición de props esperados por el componente
const props = defineProps({
    categoria: Object,
});

// Definición de emisiones del componente
const emit = defineEmits(['formSubmitted', 'closeForm']);



// Uso del hook useForm para manejar el formulario
const form = useForm({
    id: null,
    nombre: null,
    foto: null,
    currentImage: null,
});

// Observador para actualizar el formulario cuando cambia la tarea
if (props.categoria) {
    watch(props.categoria, (newVal) => {
        if (newVal) {
            form.id = newVal.id || null;
            form.currentImage = newVal.foto ? `/imagenes/fotosCategorias/${newVal.foto}` : null;
            form.nombre = newVal.nombre || '';
        }
    }, { immediate: true });
}

// Función para manejar el cambio de archivo de portada
const handleFileChange = async (event) => {
    const file = event.target.files[0];
    if (file) {
        // Si el archivo es de tipo HEIC, se convierte a PNG antes de asignarlo
        if (file.name.split('.').pop().toLowerCase() === 'heic' || file.name.split('.').pop().toLowerCase() === 'hevc' ){
            try {
                const convertedBlob = await heic2any({
                    blob: file,
                    toType: "image/png",
                });
                const convertedFile = new File([convertedBlob], file.name.split('.')[0] + '.png', { type: "image/png" });
                form.foto = convertedFile;
                form.currentImage = URL.createObjectURL(convertedFile);
            } catch (error) {
                console.error("Error converting HEIC to PNG: ", error);
            }
        } else {
            form.foto = file;
            form.currentImage = URL.createObjectURL(file);
        }
    }
};


// Función para enviar el formulario de tarea
const submit = () => {
    const data = new FormData();
    data.append('_method', form.id ? 'put' : 'post'); // Método HTTP: POST para crear, PUT para actualizar

    // Se añade la portada al FormData si existe
    if (form.foto) {
        data.append('portada', form.foto);
    }

    // Determinar la ruta adecuada según si es creación o actualización de tarea personal o de equipo
    const routeName = form.id ? 'categoria.update' : 'categoria.create';

    // Enviar los datos del formulario mediante POST o PUT
    form.post(route(routeName, form.id ? form.id : ''), {
        data,
        onSuccess: () => {
            form.reset(); // Reiniciar el formulario después del envío
            emit('formSubmitted'); // Emitir evento formSubmitted
        },
        onError: () => {},
    });
};


</script>


<template>
    <form @submit.prevent="submit" enctype="multipart/form-data" class="w-70 p-4 h-[25rem] md:h-[25rem] overflow-auto bg-amethyst-2 text-white relative rounded-lg">
                <button @click="$emit('closeForm')" class="text-gray-400 absolute right-2 top-2 text-xl font-bold focus:outline-none">
                    <font-awesome-icon :icon="['fas', 'xmark']" />
                </button>
                <h2 class="text-2xl text-amethyst-6 font-mono font-bold text-center mb-4">{{ form.id ? 'Editar' : 'Crear' }} categoría</h2>
                <div class="mt-3">
            <InputLabel for="foto" value="Foto" class="text-amethyst-7 text-sm font-bold mb-2"/>
            <div class="flex flex-col items-center justify-center w-full relative">
                <input
                    type="file"
                    id="foto"
                    name="foto"
                    class="mt-1 hidden w-full z-10 opacity-0 cursor-pointer"
                    @change="handleFileChange"
                />
                <label
                    for="foto"
                    class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer bg-white">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <div v-if="form.currentImage" class="absolute h-64 inset-0 flex items-center justify-center bg-black border-2 border-white-500 border-amethyst-5 rounded-lg cursor-pointer">
                            <img class="w-full h-full object-contain " :src="form.currentImage" alt="Vista previa de la imagen">
                        </div>
                        <font-awesome-icon :icon="['fas', 'camera']" class="text-amethyst-8 text-8xl" />
                        <p class="mb-2 text-sm text-amethyst-7"><span class="font-semibold">Seleccione la foto de la Categoría</span></p>
                    </div>

                </label>
            </div>
            <InputError :message="form.errors.foto" class="mt-2 text-red-500"/>
        </div>

                <div class="mt-4">
                    <label for="fecha_ini" class="block text-sm font-medium text-amethyst-7">Nombre</label>
                    <input type="text" id="fecha_ini" v-model="form.nombre" class="mt-1 text-black block w-full p-1 text-center"/>
                    <InputError :message="form.errors.nombre" class="mt-2"/>
                </div>


                <div class="flex items-center justify-end mt-4">
                <button type="submit" class="text-white bg-amethyst-6 hover:bg-amethyst-8 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-4 py-2 transition-colors duration-200">{{ form.id ? 'Actualizar' : 'Crear' }}</button>
                </div>
            </form>
</template>
