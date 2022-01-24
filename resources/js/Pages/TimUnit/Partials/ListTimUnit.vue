<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50" :v-on:show="getTimMember()">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No 
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Tim
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Ketua Tim
                                    </th>    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit
                                    </th>   
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori Unit
                                    </th>                                                                                                         
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Add Member</span>
                                        <span class="sr-only">Show Member</span>
                                        <span class="sr-only">Ubah Nama Tim</span>
                                        <span class="sr-only">Delete Tim</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(tim, index) in showTim" :key="tim.id">
                                    <td class="px-6 py-4 border-r-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ index+1 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.nama_karyawan }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.unit}}
                                        </div>
                                    </td>                                   
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ tim.kategori}}
                                        </div>
                                    </td>                                                                             
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex">
                                        <green-button href="#" @click.prevent="addMember(tim)" >Add Member</green-button>
                                        <blue-button href="#" @click.prevent="showMember(tim)" >Show Member</blue-button>
                                        <jet-button href="#" @click.prevent="updateTim(tim)" >Ubah Nama Tim</jet-button>
                                        <red-button href="#" @click.prevent="ConfirmingTimDeletion(tim)" >Hapus</red-button>
                                    </td>                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="addMemberModal" @close="closeModal">
        <!-- Add Member Modal -->
            <template #title>
                Tambahkan Anggota Tim
            </template>

            <template #content>
                <div class="form-group">
                    <label>Tim : {{this.selectedTim1.nama}}</label>
                </div>
                <div class="flex">
                    <green-button @click="addRow(this.selectedTim1)"> + </green-button>
                    <red-button class="mr-4" @click="deleteRow(this.selectedTim1)"> - </red-button>                
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
                            <td>
                                <div class="items-start mx-auto my-auto">
                                    <jet-input v-model="karyawan[index]" @input="filterKaryawan(index)" class=""></jet-input>
                                    <div v-if="karyawanList" class="options border-transparent h-auto" v-bind:ref="'karyawan'+index">
                                        <ul>
                                            <li v-for="karyawan in karyawanList[index]" :key="karyawan.pernum" class="hover:bg-green-600" @click="setKaryawan(karyawan, index)">
                                                {{karyawan.nama}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <jet-input-error :message="form.errors.selected" class="mt-2" />                                
                            </td>
                            <td>
                                <div class="mt-4">
                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Posisi"
                                                ref="posisi"
                                                v-model="form1.posisi[index]"
                                                @keyup.enter="create" disabled
                                                />

                                    <jet-input-error :message="form1.errors.posisi" class="mt-2" />                                
                                </div>                            
                            </td>
                        </tr>
                    </tbody>
                </table>
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <green-button class="ml-2" @click="create" :class="{ 'opacity-25': form1.processing }" :disabled="form1.processing">
                        Create
                    </green-button>
                </div>
            </template>
        </jet-dialog-modal>

        <!-- Show member Modal -->
        <jet-dialog-modal :show="timModal" @close="closeModal">
            <template #title>
                Tim {{this.selectedTim.nama}}
            </template>

            <template #content>
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">                
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 relative block">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nama Anggota
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Posisi
                                            </th>         
                                            <th scope="col" class="relative px-6 py-3">
                                                <span class="sr-only">Ubah</span>
                                                <span class="sr-only">Delete</span>
                                            </th>                                                                                       
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="tim in form1.member" :key="tim.tim_unit_id">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ tim.karyawan.nama }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ tim.posisi }}
                                                </div>
                                            </td>
                                            <td class="flex">
                                                <jet-button @click="updateMember(tim)" >Ubah</jet-button>
                                                <red-button @click="deleteMember(tim)" >Hapus</red-button>
                                            </td>
                                        </tr>

                                        <!-- More people... -->
                                    </tbody>
                                </table>

                        </div>
                    </div>                        
                </div>
            </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>    

        <!-- Delete Modal !-->

        <jet-confirmation-modal :show="deletingMember" @close="deletingMember = false">
            <template #title>
                Delete Tim
            </template>
            <template #content>
                Apakah anda yakin akan menghapus member ini?
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="deletingMember = false">
                        Cancel
                    </jet-secondary-button>

                    <red-button class="ml-2" @click="deleteProses" :class="{ 'opacity-25': form2.processing }" :disabled="form2.processing">
                        Delete Tim
                    </red-button>
                </div>
            </template>
        </jet-confirmation-modal>      

        <!--Update Member Modal-->
        <jet-dialog-modal :show="updatingMember" @close="updatingMember = false">
            <template #title>
                Ubah Anggota
            </template>
            <template #content>
                <div class="items-start mx-auto my-auto">
                    <jet-input v-model="member" @input="filterMember()" class="w-10/12"></jet-input>
                    <div v-if="memberList" class="options border-transparent" v-bind:ref="'karyawan'+index">
                        <ul>
                            <li v-for="karyawan in memberList" :key="karyawan.pernum" class="hover:bg-green-600" @click="setMember(karyawan)">
                                {{karyawan.nama}}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    <select  class="block w-10/12 py-2 border text-left border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                    v-model="form2.posisi" 
                    >
                        <option value="" disabled selected>Select Posisi</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Sekretaris">Sekretaris</option>
                        <option value="Anggota">Anggota</option>
                    </select>

                    <jet-input-error :message="form2.errors.posisi" class="mt-2" />                                
                </div>                  
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="updatingMember = false">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click="updateProses" :class="{ 'opacity-25': form2.processing }" :disabled="form2.processing">
                        Ubah
                    </jet-button>
                </div>
            </template>
        </jet-dialog-modal>

        <jet-dialog-modal :show="updatingTim" @close="closeModal">
            <template #title>
                Ubah Nama Tim
            </template>
            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4 h-auto" placeholder="Nama Tim"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4 h-auto" placeholder="Nama Unit"
                                ref="unit"
                                v-model="form.unit"
                                @keyup.enter="update" />

                    <jet-input-error :message="form.errors.unit" class="mt-2" />
                </div>            
                <div class="mt-4">
                    <select class="block w-10/12 py-2 border text-left border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="form.kategori" >
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Operasional">Operasional</option>
                        <option value="Non-Operasional">Non-Operasional</option>
                    </select>

                    <jet-input-error :message="form.errors.kategori" class="mt-2" />                    
                </div>
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Ubah
                    </jet-button>
                </div>
            </template>
        </jet-dialog-modal> 

        <jet-confirmation-modal :show="deletingTim" @close="deletingTIm = false">
            <template #title>
                Delete Tim
            </template>
            <template #content>
                Apakah anda yakin ingin menghapus tim ini?
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <red-button class="ml-2" @click="deleteAllTim">
                        Delete Tim
                    </red-button>
                </div>
            </template>
        </jet-confirmation-modal>        
    </div>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetConfirmationModal from '@/Jetstream/ConfirmationModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetConfirmButton from '@/Jetstream/ConfirmButton.vue'
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
        JetConfirmButton,
        JetConfirmationModal,
        BlueButton,
        RedButton,
        GreenButton,
    },

    props: {
        timUnits: Array,
        unitDetails:Array,
        karyawans:Array
    },

    data() {
        return {
            updatingTim:false,
            updatingMember:false,
            timModal: false,
            deletingTim: false,
            addMemberModal: false,
            deletingMember:false,
            deletingTimModal:false,
            selectedTim: {},
            selectedTim1: {},
            showTim:[],
            banyakAnggota:3,
            karyawanList:[[]],
            karyawan:[],
            memberList:[],
            member:'',            

            form: this.$inertia.form({
                nama: '',
                unit:'',
                kategori:'',
            }),
            form1: this.$inertia.form({
                tim_unit_id:'',
                pernum:[],
                posisi:[],
                member:[]
            }),
            form2: this.$inertia.form({
                tim_unit_id:'',
                pernum:'',
                posisi:'',
            }),            

        }
    },

    methods: {
        fetchKaryawan(){
            Inertia.reload({ only: ['karyawans'] })
        },

        showMember(dataTim) {
            this.timModal = true;
            var j=0;
            this.selectedTim = dataTim;
            for(var index=0;index<=this.unitDetails.length-1;index++){
                if(dataTim.id == this.unitDetails[index].tim_unit_id){
                    this.form1.member[j] = this.unitDetails[index];
                    j++;
                }
            }
        },

        addMember(unitDetail){
            this.addMemberModal = true;
            this.selectedTim1 = unitDetail;
            this.form1.tim_unit_id = unitDetail.id;
            for(var index=0;index<=this.banyakAnggota-1;index++){
                this.form1.posisi[index] = 'Anggota';
            }
        },

        updateMember(tim){
            this.fetchKaryawan();
            this.updatingMember = true;
            this.selectedTim = tim;
            this.member = tim.karyawan.nama
            this.form2.tim_unit_id = tim.tim_unit_id;
            this.form2.pernum = tim.pernum;
            this.form2.posisi = tim.posisi;          
        },

        updateProses() {
            this.form2.put(route('unitDetail.update', this.selectedTim.id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.updatingMember = false;
                    this.form1.reset();
                    this.showMember(this.selectedTim);                      
                }
            })
        },

        updateTim(tim){
            this.updatingTim = true;
            this.selectedTim = tim;
            this.form.nama = tim.nama;
            this.form.unit = tim.unit;
            this.form.kategori = tim.kategori;
        },

        update() {
            this.form.put(route('timUnit.update', this.selectedTim.id), {
                preserveScroll: true,
                preserveState:true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
                onError: () => this.$refs.nama.focus(),
            })
        },

        ConfirmingTimDeletion(tim) {
            this.deletingTim = true;
            this.selectedTim = tim;

        },

        deleteAllTim(){
            this.form1.tim_unit_id = this.selectedTim.id;
            this.form1.delete(route('DeleteTimUnit', this.selectedTim.id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });            
        },
        getTimMember(){
            var unitDetail = this.unitDetails;
            var daftarTim = this.timUnits;
            this.showTim = this.timUnits;
            for(var index=0;index<=daftarTim.length-1;index++){
                for(var k=0;k<=unitDetail.length-1;k++){
                    if(unitDetail[k].posisi == 'Ketua' && unitDetail[k].tim_unit_id == daftarTim[index].id){
                        this.showTim[index].nama_karyawan = unitDetail[k].karyawan.nama;
                    }
                }
            }
        },

        deleteTim() {
            this.form.delete(route('unitDetail.destroy', this.selectedTim.tim_unit_id), {
                preserveScroll: true,
                errorBag: 'delete',
                onSuccess: () => this.closeModal()
            });
        },
        create(){
            this.form1.post(route('unitDetail.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form1.reset();
                },
            })            
        },

        deleteMember(dataTim){
            this.selectedTim = dataTim;
            this.deletingMember = true;
        },

        deleteProses() {
            this.form2.delete(route('unitDetail.destroy', this.selectedTim.id), {
                preserveScroll: true,
                preserveState:true,
                errorBag: 'delete',
                onSuccess: () => {
                    this.deletingMember = false;

                },
                onFinish: () =>{
                    this.form1.reset();
                    this.timModal = false;
                    this.showMember(this.selectedTim);                    
                }
            })
        },

        closeModal() {
            this.updatingTim = false,
            this.deletingTim = false,
            this.timModal = false,
            this.addMemberModal = false,
            this.deletingTimModal = false,
            

            this.form.reset(),
            this.form1.reset(),
            this.form2.reset()
        },
        addRow(tim){
            this.banyakAnggota++;
            this.addMember(tim);
        },
        deleteRow(){
            this.banyakAnggota--;
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
            this.form1.pernum[index] = karyawan.pernum;
            this.karyawanList = [[]];
        },
        filterMember(){
            const query = this.member.toLowerCase();
            if(this.member === ''){
                return this.memberList;
            }
            this.memberList = this.karyawans.filter((nama) => {
                return Object.values(nama).some((word) => String(word).toLowerCase().includes(query));
            })
        },
        setMember(karyawan){
            this.member = karyawan.nama
            this.form2.pernum = karyawan.pernum;
            this.memberList = [];
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
