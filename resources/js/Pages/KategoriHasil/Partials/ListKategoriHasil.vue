<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai Atas
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nilai Bawah
                                    </th>          
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>                                                                        
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="kategoriHasil in kategoriHasils" :key="kategoriHasil.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kategoriHasil.nilai_atas }}
                                        </div>
                                    </td>                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kategoriHasil.nilai_bawah }}
                                        </div>
                                    </td>                                                                                                            
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kategoriHasil.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right flex text-sm font-medium justify-end">
                                        <jet-button class="w-52" href="#" @click.prevent="updateKategoriHasil(kategoriHasil)" >Edit  </jet-button>
                                         
                                        <red-button class="w-52" href="#" @click.prevent="ConfirmingKategoriHasilDeletion(kategoriHasil)" >Hapus</red-button>
                                    </td>                                    
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update KategoriHasil Modal -->
        <jet-dialog-modal :show="updatingKategoriHasil" @close="closeModal">
            <template #title>
                Update KategoriHasil
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="form.nilai_atas"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nilai_atas" class="mt-2" />
                </div>                  
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="form.nilai_bawah"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nilai_bawah" class="mt-2" />
                </div>                  
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="KategoriHasil"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>
              
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Update
                    </jet-button>
                </div>
            </template>
        </jet-dialog-modal>    

        <!-- Delete Modal !-->

        <jet-dialog-modal :show="deletingKategoriHasil" @close="deletingKategoriHasil = false">
            <template #title>
                Delete Kategori Hasil
            </template>
            <template #content>
                Yakin ingin menghapus??
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="deletingKategoriHasil = false">
                        Cancel
                    </jet-secondary-button>

                    <red-button class="ml-2" @click="deleteKategoriHasil" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Kategori Hasil
                    </red-button>
                </div>
            </template>
        </jet-dialog-modal>            
    </div>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import BlueButton from '@/Components/BlueButton.vue'
import RedButton from '@/Components/RedButton.vue'
import GreenButton from '@/Components/GreenButton.vue'


export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetCheckbox,
        RedButton,
        GreenButton,
        BlueButton,
    },

    props: {
        kategoriHasils: Array
    },

    data() {
        return {
            updatingKategoriHasil: false,
            deletingKategoriHasil: false,
            selectedKategoriHasil: {},

            form: this.$inertia.form({
                nilai_atas: '',
                nilai_bawah: '',
                nama: '',
                               
            })
        }
    },

    methods: {
        updateKategoriHasil(kategoriHasil) {
            this.updatingKategoriHasil = true;
            this.selectedKategoriHasil = kategoriHasil;
            this.form.nilai_atas = kategoriHasil.nilai_atas;
            this.form.nilai_bawah = kategoriHasil.nilai_bawah;
            this.form.nama = kategoriHasil.nama;
            this.form.sub_kategoriHasil = kategoriHasil.sub_kategoriHasil;

            setTimeout(() => this.$refs.nilai_atas.focus(), 250)
        },

        update() {
            this.form.put(route('kategoriHasil.update', this.selectedKategoriHasil.id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nilai_atas.focus(),
                onFinish: () => this.form.reset(),
            })
        },
        ConfirmingKategoriHasilDeletion(kategoriHasil) {
            this.deletingKategoriHasil = true;
            this.selectedKategoriHasil = kategoriHasil;

        },

        deleteKategoriHasil() {
            this.form.delete(route('kategoriHasil.destroy', this.selectedKategoriHasil.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },        

        closeModal() {
            this.updatingKategoriHasil = false,
            this.deletingKategoriHasil = false,

            this.form.reset()
        },
    },
}
</script>
