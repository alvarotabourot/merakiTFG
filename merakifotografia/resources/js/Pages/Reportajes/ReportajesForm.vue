<script setup>
import { ref, watch } from 'vue'; // Importación de ref y watch desde Vue 3
import InputError from '@/Components/InputError.vue'; // Importación del componente InputError
import InputLabel from '@/Components/InputLabel.vue'; // Importación del componente InputLabel
import PrimaryButton from '@/Components/PrimaryButton.vue'; // Importación del componente PrimaryButton
import TextInput from '@/Components/TextInput.vue'; // Importación del componente TextInput
import { useForm } from '@inertiajs/vue3'; // Importación de useForm desde Inertia.js
import { defineProps, defineEmits } from 'vue'; // Importación de defineProps y defineEmits desde Vue 3
import heic2any from 'heic2any'; // Importación de la librería heic2any para convertir fotos HEIC

// Definición de props esperados por el componente
const props = defineProps({
    reportaje: Object,
    categorias: Array,

});

// Definición de emisiones del componente
const emit = defineEmits(['formSubmitted', 'closeForm']);


// Uso del hook useForm para manejar el formulario
const form = useForm({
    id: null,
    foto: null, // foto de foto de la reportaje
    fotos: [], // Array de fotos adjuntos
    fotosExistentes: [], // fotos existentes asociados a la reportaje
    fotosParaEliminar: [], // fotos a eliminar asociados a la reportaje
    fecha: '', // Fecha de inicio (convertida a ISO local si existe)
    nombre: '', // Título de la reportaje
    descripcion: '', // Descripción de la reportaje
    categoria_id: null, // ID de la categoria asociada a la reportaje
    currentImage: null, // Imagen actual de la reportaje
});

// Observador para actualizar el formulario cuando cambia la reportaje
if (props.reportaje) {
    watch(props.reportaje, (newVal) => {
        if (newVal) {
            form.id = newVal.id || null;
            form.currentImage = newVal.foto ? `/imagenes/fotosReportajes/${newVal.foto}` : null;
            form.nombre = newVal.nombre || '';
            form.descripcion = newVal.descripcion || '';
            form.fecha = newVal.fecha || '';
            form.fotosExistentes = newVal.fotos || [];
            form.categoria_id = newVal.categoria_id || null;
        }
    }, { immediate: true });
}

// Función para manejar el cambio de foto de foto
const handleFileChange = async (event) => {
    const file = event.target.files[0];
    if (file) {
        // Si el foto es de tipo HEIC, se convierte a PNG antes de asignarlo
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

// Función para manejar el cambio de fotos adjuntos
const handleFilesChange = (event) => {
    form.fotos = [...event.target.files];
};

// Función para enviar el formulario de reportaje
const submit = () => {
    const data = new FormData();
    data.append('_method', form.id ? 'put' : 'post'); // Método HTTP: POST para crear, PUT para actualizar

    // Añadir la foto principal si existe
    if (form.foto) {
        data.append('foto', form.foto);
    }

    // Añadir todas las fotos nuevas
    form.fotos.forEach((file, index) => {
        data.append(`fotos[${index}]`, file);
    });

    // Añadir las fotos para eliminar
    form.fotosParaEliminar.forEach((fotoId) => {
        data.append('fotos_para_eliminar[]', fotoId);
    });

    // Añadir otros campos necesarios como nombre, descripcion, etc.
    data.append('nombre', form.nombre);
    data.append('descripcion', form.descripcion);
    data.append('fecha', form.fecha);
    data.append('categoria_id', form.categoria_id);

    const routeName = form.id ? 'reportaje.update' : 'reportaje.create';

    form.post(route(routeName, form.id || ''), {
        data,
        onSuccess: () => {
            form.reset();
            emit('formSubmitted');
        },
        onError: () => {},
    });
};

// Función para eliminar un foto asociado a la reportaje
const eliminarFoto = (fotoId) => {
    form.fotosParaEliminar.push(fotoId);
    form.fotosExistentes = form.fotosExistentes.filter(foto => foto.id !== fotoId);
};


// Define la variable reactiva para controlar la visibilidad
const mostrarFotos = ref(false);

// Función para alternar la visibilidad
const toggleFotos = () => {
    mostrarFotos.value = !mostrarFotos.value;
};
</script>


<template>
    <form @submit.prevent="submit" enctype="multipart/form-data" class="w-70 p-4 h-[30rem] overflow-auto bg-amethyst-2 text-white relative rounded-lg">
        <button @click="$emit('closeForm')" class="text-gray-400 div absolute right-2 top-2 text-xl font-bold focus:outline-none">
            <font-awesome-icon :icon="['fas', 'xmark']" />
        </button>
        <h2 class="text-2xl text-amethyst-6 font-mono font-bold text-center mb-4">{{ form.id ? 'Editar' : 'Crear' }} reportaje</h2>
        <p class="text-center text-sm text-amethyst-6 mb-4">Completa los detalles a continuación para {{ form.id ? 'actualizar' : 'crear' }} el reportaje.</p>
        <div class="mt-3">
            <InputLabel for="foto" value="Portada" class="text-amethyst-6"/>
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
                    class="flex flex-col items-center justify-center w-full h-64 border-2 b border-dashed rounded-lg cursor-pointer bg-white">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <div v-if="form.currentImage" class="absolute h-64 inset-0 flex items-center justify-center bg-black border-2   rounded-lg cursor-pointer">
                            <img class="w-full h-full object-contain " :src="form.currentImage" alt="Vista previa de la imagen">
                        </div>
                        <font-awesome-icon :icon="['fas', 'camera']" class="text-amethyst-8 text-8xl" />
                        <p class="mb-2 text-sm text-amethyst-7"><span class="font-semibold">Pincha para subir</span> o arrastra y suelta</p>
                    </div>

                </label>
            </div>
            <InputError :message="form.errors.foto" class="mt-2 text-red-500"/>
        </div>

        <div class="mt-4">
            <InputLabel for="fotos" value="Subir fotos al reportaje" class="text-amethyst-6"/>
            <input type="file" id="fotos" name="fotos" class="mt-1 block w-full text-amethyst-8 bg-white border-green-500" multiple @change="handleFilesChange"/>
            <InputError :message="form.errors.fotos" class="mt-2 text-red-500"/>
        </div>



        <div class="mt-4">
            <InputLabel for="nombre" value="Título" class="text-amethyst-6"/>
            <TextInput id="nombre" v-model="form.nombre" class="mt-1 block w-full bg-white text-amethyst-8 border-green-500 p-1" />
            <InputError :message="form.errors.nombre" class="mt-2 text-red-500"/>
        </div>

        <div class="mt-4">
            <InputLabel for="descripcion" value="Descripción" class="text-amethyst-6"/>
            <textarea id="descripcion" v-model="form.descripcion" class="mt-1 block w-full bg-wite text-amethyst-8 border-green-500 p-1"></textarea>
            <InputError :message="form.errors.descripcion" class="mt-2 text-red-500"/>
        </div>

        <div class="mt-4">
            <InputLabel for="fecha" value="Fecha" class="text-amethyst-6"/>
            <input type="date" id="fecha" v-model="form.fecha" class="mt-1 block w-full bg-white text-amethyst-8 border-green-500 p-1"/>
            <InputError :message="form.errors.fecha" class="mt-2 text-red-500"/>
        </div>

        <div class="mt-4">
            <InputLabel for="categoria_id" value="Categoria" class="text-amethyst-6"/>
            <select id="categoria_id" v-model="form.categoria_id" class="mt-1 block w-full bg-white text-amethyst-8 border-green-500 p-1">
                <option value="">Seleccione una categoria</option>
                <option v-for="categoria in categorias" :value="categoria.id">{{ categoria.nombre }}</option>
            </select>
            <InputError :message="form.errors.categoria_id" class="mt-2 text-red-500"/>
        </div>

        <div v-if="form.fotosExistentes.length > 0">
            <div class="mt-4">
                <InputLabel value="Fotos existentes" class="text-amethyst-6"/>
                <button type="button" @click="toggleFotos" class="bg-amethyst-6 text-white px-3 py-1 rounded-full">
                    {{ mostrarFotos ? 'Ocultar' : 'Mostrar' }} Fotos
                </button>

                <div v-if="mostrarFotos" class="mt-1 block w-full">
                    <div v-for="foto in form.fotosExistentes" :key="foto.id" class="text-green-500 flex items-center gap-4">
                        <img :src="`/imagenes/fotosReportajes/${foto.url}`" target="_blank" class="inline-block w-50 overflow-hidden mt-2">
                        <button type="button" @click="eliminarFoto(foto.id)" class="bg-red-500 text-white px-2 py-1 rounded-full">
                            Eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="mt-4">
            <div class="text-amethyst-8 flex items-center gap-4">
                Este reportaje no tiene fotos.
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <Button class="bg-amethyst-6 hover:bg-amethyst-8 text-white ml-4 pl-2 pr-2 rounded-full">
                {{ form.id ? 'Actualizar' : 'Crear' }}
            </Button>
        </div>
    </form>
</template>
