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
                                        Kriteria
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sub Kriteria
                                    </th>     
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keterangan
                                    </th>                                                                      
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="kriteria in kriterias" :key="kriteria.nama">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kriteria.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kriteria.sub_kriteria }}
                                        </div>
                                    </td>         
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ kriteria.keterangan}}
                                        </div>
                                    </td>                                                                 
                                    <td class="px-6 py-4 whitespace-nowrap flex text-right text-sm font-medium">
                                        <blue-button href="#" class="w-52" @click.prevent="showNilai(kriteria)" >Rank Nilai</blue-button>
                                        <jet-button href="#" @click.prevent="updateKriteria(kriteria)">Edit  </jet-button>
                                        <red-button href="#" @click.prevent="ConfirmingKriteriaDeletion(kriteria)">Hapus</red-button>
                                    </td>                                    
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Kriteria Modal -->
        <jet-dialog-modal :show="updatingKriteria" @close="closeModal">
            <template #title>
                Update Kriteria
            </template>

            <template #content>
                <div class="mt-4">
                    <select  class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="form.nama">
                                        
                        <option value="" disabled selected>Select Kriteria</option>
                        <option value="P1">P1</option>
                        <option value="P2">P2</option>
                        <option value="P3">P3</option>
                        <option value="P4">P4</option>
                        <option value="P5">P5</option>
                    </select>

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Sub Kriteria"
                                ref="sub_kriteria"
                                v-model="form.sub_kriteria"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.sub_kriteria" class="mt-2" />
                </div>   
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Keterangan"
                                ref="keterangan"
                                v-model="form.keterangan"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.keterangan" class="mt-2" />
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

        <jet-dialog-modal :show="deletingKriteria" @close="deletingKriteria = false">
            <template #title>
                Delete Kriteria
            </template>
            <template #content>
                Yakin ingin menghapus??
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="deletingKriteria = false">
                        Cancel
                    </jet-secondary-button>

                    <red-button class="ml-2" @click="deleteKriteria" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Kriteria
                    </red-button>
                </div>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="showModal" @close="closeModal" :max-width="maxWidth">
            <template #title>
                Daftar Rank Nilai {{this.selectedKriteria.nama}} {{this.selectedKriteria.sub_kriteria}}
            </template>

            <template #content>
                <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                    <green-button @click="tambahRank(this.selectedKriteria)" class="w-1/4">Tambah Rank Penilaian</green-button>
                </h2>
                <div class="mt-4">
                    <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>                                   
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nilai
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Ubah</span>
                                    <span class="sr-only">Hapus</span>
                                </th>                                                           
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="penilaian in list.listNilai" :key="penilaian.id">                                                                        
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{penilaian.nilai_bawah}} - {{penilaian.nilai_atas}}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ penilaian.keterangan }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <jet-button class="w-1/2" @click="updateNilai(penilaian)">Ubah</jet-button>
                                        <red-button class="w-1/2" @click="ConfirmingNilaiDeletion(penilaian)">Hapus</red-button>
                                    </div>
                                </td>                                                            
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    </div>
                    </div>
                    </div>
                </div>
            </template>
            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Close
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="tambahModal" @close="tambahModal = false">
            <template #title>
                Buat Rank Nilai {{this.selectedKriteria.nama}} {{this.selectedKriteria.sub_kriteria}}
            </template>

            <template #content>


                <div class="mt-4">
                    <select class="block w-10/12 py-2 border text-left border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="tambah.kriteria_id" disabled>
                        <option value="" disabled selected>Select Category</option>
                        <option v-for="kriteria in kriterias" :key="kriteria.id" :value="kriteria.id">{{kriteria.nama}} {{'-'}} {{ kriteria.sub_kriteria }}</option>
                    </select>

                    <jet-input-error :message="tambah.errors.kriteria_id" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="tambah.nilai_bawah"
                                @keyup.enter="create" min="0" max="100"/>

                    <jet-input-error :message="tambah.errors.nilai_bawah" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="tambah.nilai_atas"
                                @keyup.enter="create" />

                    <jet-input-error :message="tambah.errors.nilai_atas" class="mt-2" />
                </div>                

                <div class="mt-4">
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Keterangan"
                                ref="keterangan"
                                v-model="tambah.keterangan"
                                rows="4"
                                cols="50">
                    </textarea>

                    <jet-input-error :message="tambah.errors.keterangan" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="tambahModal = false">
                        Cancel
                    </jet-secondary-button>

                    <green-button class="ml-2" @click="create" :class="{ 'opacity-25': tambah.processing }" :disabled="tambah.processing">
                        Create
                    </green-button>
                </div>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="deletingNilai" @close="deletingNilai = false">
            <template #title>
                Delete Nilai
            </template>
            <template #content>
                Anda yakin ingin menghapus ini?
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="deletingNilai = false">
                        Cancel
                    </jet-secondary-button>

                    <red-button class="ml-2" @click="deleteNilai" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Nilai
                    </red-button>
                </div>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="updatingNilai" @close="closeModal">
            <template #title>
                Ubah Data Nilai
            </template>

            <template #content>


                <div class="mt-4">
                    <select class="block w-52 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="tambah.kriteria_id" disabled>
                        <option value="" disabled selected>Select Category</option>
                        <option v-for="kriteria in kriterias" :key="kriteria.id" :value="kriteria.id">{{kriteria.nama}} {{'-'}} {{ kriteria.sub_kriteria }}</option>
                    </select>

                    <jet-input-error :message="tambah.errors.kriteria_id" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="tambah.nilai_bawah"
                                @keyup.enter="update" />

                    <jet-input-error :message="tambah.errors.nilai_bawah" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="tambah.nilai_atas"
                                @keyup.enter="update" />

                    <jet-input-error :message="tambah.errors.nilai_atas" class="mt-2" />
                </div>  

                <div class="mt-4">
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Keterangan"
                                ref="keterangan"
                                v-model="tambah.keterangan"
                                rows="4"
                                cols="50" />

                    <jet-input-error :message="tambah.errors.keterangan" class="mt-2" />
                </div>
            </template>
            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="updatingNilai = false">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click="updateRank()" :class="{ 'opacity-25': tambah.processing }" :disabled="tambah.processing">
                        Update
                    </jet-button>
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
import RedButton from '@/Components/RedButton.vue'
import GreenButton from '@/Components/GreenButton.vue'
import BlueButton from '@/Components/BlueButton.vue'

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
        kriterias: Array,
        nilais:Array,
    },

    data() {
        return {
            updatingKriteria: false,
            deletingKriteria: false,
            showModal:false,
            tambahModal:false,
            deletingNilai:false,
            updatingNilai:false,
            selectedKriteria: {},
            selectedRank:{},

            list:this.$inertia.form({
                listNilai:[],
            }),

            form: this.$inertia.form({
                nama: '',
                sub_kriteria: '',    
                keterangan:''
            }),

            tambah: this.$inertia.form({
                kriteria_id: '',
                nilai_bawah: '',
                nilai_atas: '',
                keterangan: '',
            }),
            maxWidth:'3xl'
        }
    },

    methods: {
        showNilai(nilai){
            this.form.reset();
            this.showModal = true;
            this.selectedKriteria = nilai;
            var x = 0;
            for(var i=0;i<this.nilais.length;i++){
                if(this.nilais[i].kriteria_id == nilai.id){
                    this.list.listNilai[x] = this.nilais[i];
                    x++;
                }
            }

        },

        tambahRank(rank){
            this.tambah.reset();
            this.tambahModal = true;
            this.tambah.kriteria_id = rank.id;
        },

        create() {
            this.tambah.post(route('nilai.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.tambahModal = false;
                    this.list.reset();
                    this.showNilai(this.selectedKriteria);
                },
            })
        },

        updateKriteria(kriteria) {
            this.updatingKriteria = true;
            this.selectedKriteria = kriteria;
            this.form.nama = kriteria.nama;
            this.form.sub_kriteria = kriteria.sub_kriteria;
            this.form.keterangan = kriteria.keterangan;

        },

        update() {
            this.form.put(route('kriteria.update', this.selectedKriteria.id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nama.focus(),
                onFinish: () => this.form.reset(),
            })
        },
        ConfirmingKriteriaDeletion(kriteria) {
            this.deletingKriteria = true;
            this.selectedKriteria = kriteria;

        },

        deleteKriteria() {
            this.form.delete(route('kriteria.destroy', this.selectedKriteria.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },
        
        ConfirmingNilaiDeletion(nilai){
            this.deletingNilai = true;
            this.selectedRank = nilai;
        },

        deleteNilai() {
            this.tambah.delete(route('nilai.destroy', this.selectedRank.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => {
                    this.deletingNilai = false;
                    this.list.reset();
                    this.showNilai(this.selectedKriteria);
                }
            });
        }, 

        updateNilai(nilai){
            this.tambah.reset();
            this.updatingNilai = true;
            this.selectedRank = nilai;
            this.tambah.kriteria_id = nilai.kriteria_id;
            this.tambah.nilai_bawah = nilai.nilai_bawah;
            this.tambah.nilai_atas = nilai.nilai_atas;
            this.tambah.keterangan = nilai.keterangan;

        },

        updateRank() {
            this.tambah.put(route('nilai.update', this.selectedRank.id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.updatingNilai = false;
                    this.list.reset();
                    this.showNilai(this.selectedKriteria);

                },
                onError: () => this.$refs.nama.focus(),
            })
        },

        closeModal() {
            this.updatingKriteria = false;
            this.deletingKriteria = false;
            this.showModal = false;
            this.list.reset();

            this.form.reset();
        },
    },
}
</script>
