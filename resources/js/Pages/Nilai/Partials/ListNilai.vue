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
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Show Nilai</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="nilai in kriterias" :key="nilai.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ nilai.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ nilai.sub_kriteria }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap flex text-right text-sm font-medium justify-end">
                                        <blue-button href="#" class="w-52" @click.prevent="showNilai(nilai)" >Show Detail</blue-button>
                                    </td>                                                                
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="showModal" @close="closeModal" :max-width="maxWidth">
            <template #title>
                Daftar Rank Nilai {{this.selectedNilai.nama}} {{this.selectedNilai.sub_kriteria}}
            </template>

            <template #content>
                <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                    <green-button @click="tambahRank(this.selectedNilai)" class="w-1/4">Tambah Rank Penilaian</green-button>
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
                                        <jet-button class="w-52" @click="updateNilai(penilaian)">Ubah</jet-button>
                                        <red-button class="w-52" @click="ConfirmingNilaiDeletion(penilaian)">Hapus</red-button>
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

        <!-- Update Nilai Modal -->
        <jet-dialog-modal :show="updatingNilai" @close="closeModal">
            <template #title>
                Ubah Data Nilai
            </template>

            <template #content>


                <div class="mt-4">
                    <select class="block w-52 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="form.kriteria_id" disabled>
                        <option value="" disabled selected>Select Category</option>
                        <option v-for="kriteria in kriterias" :key="kriteria.id" :value="kriteria.id">{{kriteria.nama}} {{'-'}} {{ kriteria.sub_kriteria }}</option>
                    </select>

                    <jet-input-error :message="form.errors.kriteria_id" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="form.nilai_bawah"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nilai_bawah" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="form.nilai_atas"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nilai_atas" class="mt-2" />
                </div>  

                <div class="mt-4">
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Keterangan"
                                ref="keterangan"
                                v-model="form.keterangan"
                                rows="4"
                                cols="50" />

                    <jet-input-error :message="form.errors.keterangan" class="mt-2" />
                </div>
            </template>
            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="updatingNilai = false">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Update
                    </jet-button>
                </div>
            </template>
        </jet-dialog-modal>    

        <!-- Delete Modal !-->

        <jet-dialog-modal :show="deletingNilai" @close="deletingNilai = false">
            <template #title>
                Delete Nilai
            </template>
            <template #content>
                Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.
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

        <jet-dialog-modal :show="tambahModal" @close="tambahModal = false">
            <template #title>
                Buat Rank Nilai {{this.selectedNilai.nama}} {{this.selectedNilai.sub_kriteria}}
            </template>

            <template #content>


                <div class="mt-4">
                    <select class="block w-10/12 py-2 border text-left border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="form.kriteria_id" disabled>
                        <option value="" disabled selected>Select Category</option>
                        <option v-for="kriteria in kriterias" :key="kriteria.id" :value="kriteria.id">{{kriteria.nama}} {{'-'}} {{ kriteria.sub_kriteria }}</option>
                    </select>

                    <jet-input-error :message="form.errors.kriteria_id" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="form.nilai_bawah"
                                @keyup.enter="create" min="0" max="100"/>

                    <jet-input-error :message="form.errors.nilai_bawah" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="form.nilai_atas"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nilai_atas" class="mt-2" />
                </div>                

                <div class="mt-4">
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Keterangan"
                                ref="keterangan"
                                v-model="form.keterangan"
                                rows="4"
                                cols="50">
                    </textarea>

                    <jet-input-error :message="form.errors.keterangan" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="tambahModal = false">
                        Cancel
                    </jet-secondary-button>

                    <green-button class="ml-2" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Create
                    </green-button>
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
import { Inertia } from '@inertiajs/inertia'
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
        GreenButton,
        RedButton,
        BlueButton,
    },

    props: {
        nilais: Array,
        kriterias:Array
    },

    data() {
        return {
            updatingNilai: false,
            deletingNilai: false,
            showModal:false,
            tambahModal:false,
            selectedNilai: {},
            selectedRank:{},
            maxWidth:'3xl',

            form: this.$inertia.form({
                kriteria_id: '',
                nilai_bawah: '',
                nilai_atas: '',
                keterangan: '',
            }),

            list:this.$inertia.form({
                listNilai:[],
            }),
        }
    },

    methods: {
        showNilai(nilai){
            this.list.reset();
            this.showModal = true;
            this.selectedNilai = nilai;
            var x = 0;
            for(var i=0;i<this.nilais.length;i++){
                if(this.nilais[i].kriteria_id == nilai.id){
                    this.list.listNilai[x] = this.nilais[i];
                    x++;
                }
            }

        },
        tambahRank(rank){
            this.form.reset();
            this.tambahModal = true;
            this.form.kriteria_id = rank.id;
        },
        create() {
            this.form.post(route('nilai.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.tambahModal = false;
                    this.list.reset();
                    this.showNilai(this.selectedNilai);
                },
            })
        },

        updateNilai(nilai) {
            this.form.reset();
            this.updatingNilai = true;
            this.selectedRank = nilai;
            this.form.kriteria_id = nilai.kriteria_id;
            this.form.nilai_bawah = nilai.nilai_bawah;
            this.form.nilai_atas = nilai.nilai_atas;
            this.form.keterangan = nilai.keterangan;

        },     

        update() {
            this.form.put(route('nilai.update', this.selectedRank.id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.updatingNilai = false;
                    this.list.reset();
                    this.showNilai(this.selectedNilai);

                },
                onError: () => this.$refs.nama.focus(),
            })
        },
        ConfirmingNilaiDeletion(nilai) {
            this.deletingNilai = true;
            this.selectedRank = nilai;

        },

        deleteNilai() {
            this.form.delete(route('nilai.destroy', this.selectedRank.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => {
                    this.deletingNilai = false;
                    this.list.reset();
                    this.showNilai(this.selectedNilai);
                }
            });
        },        

        closeModal() {
            this.showModal = false,
            this.form.reset()
        },
    },
}
</script>

<style scoped>
    .wrappingText{
        display: inline-block;/* or inline-block */
        text-overflow: ellipsis;
        word-wrap: break-word;
        overflow: hidden;
        max-height: 3.6em;
        line-height: 1.8em;
    }
</style>