<template>
    <app-layout :showPenilaian="true">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Tim Detail
                <create-tim />
            </h2>
        </template>    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg" v-if="tims.nama != null" >                
        <!-- Delete Account Confirmation Modal -->


                                <div class="form-group" >
                                    <div :v-on:show ="getTimId()" class="bg-white bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                                        <div class="items-center leading-none p-2 shadow text-teal text-sm border-transparent bg-transparent">
                                            <div>Tambahkan Anggota Tim</div>
                                            <br>

                                            <div class="items-center leading-none p-2 shadow text-teal text-sm border-transparent bg-transparent">
                                                <span class="inline-flex bg-gray-700 text-white h-6 px-3 justify-center items-center">Tim :</span>
                                                <span class="inline-flex px-2 text-gray-700"> {{this.tims.nama}} </span> 

                                            </div>                                            
                                        </div>
                                        <div class="sm:-my-px sm:ml-1 sm:flex justify-end">
                                            <green-button class="w-1/4 h-10" @click="addRow">+</green-button>
                                            <red-button class="mr-4 w-1/4 h-10" @click="deleteRow">-</red-button>                
                                        </div>                                        
                                    </div>

                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead>
                                            <tr>
                                                <th>Nama Anggota</th>
                                                <th>Posisi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(n, index) in banyakAnggota" :key="index">
                                                <td class="mr-4 mx-auto justify-start w-auto h-auto">
                                                    <div class="items-start mx-auto my-auto">
                                                        <jet-input v-model="karyawan[index]" @input="filterKaryawan(index)" class=""></jet-input>
                                                        <div v-if="karyawanList" class="options border-transparent" v-bind:ref="'karyawan'+index">
                                                            <ul>
                                                                <li v-for="karyawan in karyawanList[index]" :key="karyawan.pernum" class="hover:bg-green-600" @click="setKaryawan(karyawan, index)">
                                                                    {{karyawan.nama}}
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="mt-4">
                                                        <select  class="block w-10/12 py-2 border text-left border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                            v-model="form.posisi[index]" 
                                                            v-bind:id="'posisi' + n">
                                                            
                                                            <option value="" disabled selected>Select Karyawan</option>
                                                            <option value="Ketua">Ketua</option>
                                                            <option value="Anggota">Anggota</option>
                                                        </select>

                                                        <jet-input-error :message="form.errors.posisi" class="mt-2" />                                
                                                    </div>                            
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="place-self-end">
                                    <green-button class="ml-2 py-4 w-1/4" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Create
                                    </green-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>       
    </app-layout>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import RedButton from '@/Components/RedButton.vue'
import GreenButton from '@/Components/GreenButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/AppLayout.vue'

export default {
    components: {
        AppLayout,
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        RedButton,
        GreenButton,
    },

    props: {
        tims: Array,
        karyawans:Array
    },

    data() {
        return {
            creatingTimDetail: false,
            banyakAnggota:3,
            karyawanList:[[]],
            karyawan:[],
            
            form: this.$inertia.form({
                tim_id: '',
                selected: [],
                posisi: [],
            })
        }
    },
    mounted(){

    },

    methods: {

        createTimDetail() {
            this.fetchKaryawans();
            this.fetchTims();
            this.creatingTimDetail = true;
        },

        fetchTims() {
            Inertia.reload({ only: ['tims'] })
        },

        fetchKaryawans() {
            Inertia.reload({ only: ['karyawans'] })
        },

        create() {
            this.form.post(route('timDetail.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
            })
        },
        getTimId(){
            this.form.tim_id = this.tims.tim_id
        },

        closeModal() {
            this.form.clearErrors()
            this.form.reset()
            return route('tim.index');
        },
        addRow(){
            this.banyakAnggota++
        }, 
        deleteRow(){
            this.banyakAnggota--
        },
        filterKaryawan(index){
            const query = this.karyawan[index].toLowerCase();
            if(this.karyawan[index] === ''){
                return this.karyawanList[index];
            }
            this.karyawanList[index] = this.karyawans.filter((nama) => {
                return Object.values(nama).some((word) => String(word).toLowerCase().includes(query));
            })
        },
        setKaryawan(karyawan, index){
            this.karyawan[index] = karyawan.nama;
            this.form.selected[index] = karyawan.nip;
            this.karyawanList = [[]];
        },
    },
}
</script>

<style scoped>
        input{
            width: 90%;
            height: 30px;
            border: 2px solid lightgray;
            font-size: 18px;
            padding-left: 5px;

        }
        .options{
            width: 75%;
        }        
            ul{
                list-style: none;
                text-align: left;
                padding-left: 8px;
                max-height: 200px;
                overflow-y: scroll;
                overflow-x: hidden;
                border: 1px solid lightgray;
            }
            li{
                width: 100%;
                border-bottom: 1px solid lightgray;
                padding: 10px;
                background-color: #f1f1f1;
                cursor: pointer;
            }
            
</style>
