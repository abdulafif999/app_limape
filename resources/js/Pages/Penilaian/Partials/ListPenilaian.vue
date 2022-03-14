<template>
    <div>
        <div class="bg-white text-left justify-center text-gray-600 capitalize h-12 border" v-if="$page.props.user.role=='user'">
            <label class="h-10 uppercase text-lg block bold font-bold">
                List Penilaian Yang Belum di Finalisasi
            </label>
        </div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col" :v-bind="data.dataPenilaian">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-min divide-y divide-gray-200 mb-5 border-black table table-bordered" style="width:100%">
                            <tr class="mb-3 border-b-2">                                
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pencarian
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>                          
                                    <th scope="col"
                                        class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-3 ml-9 text-left justify-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    
                                    </th>
                            
                                    <th scope="col"
                                        class="text-left justify-end items-end ml-6 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cari Tim
                                        <div v-if="$page.props.user.role=='admin'">
                                            <select  class="block w-52 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                @change="searchTerm()" v-model="term" id="search" type="text" >
                                                                                        
                                                <option value="">Pilih Tim 5P/Unit</option>
                                                <option value="semua">Semua</option>
                                                <option v-for="tim in timUnits" :key="tim.id" :value="tim.id" >{{tim.nama}}</option>
                                            </select>
                                        </div>
                                        <div v-else-if="$page.props.user.role=='user'">
                                            <select  class="block w-52 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                @change="searchTerm()" v-model="term" id="search" type="text" >
                                                                                        
                                                <option value="">Pilih Tim 5P/Unit</option>
                                                <option value="semua">Semua</option>
                                                <option v-for="tim in tim_yg_dinilai" :key="tim.tim_unit_id" :value="tim.tim_unit.id" >{{tim.tim_unit.nama}}</option>
                                            </select>
                                        </div>
                                    </th>                                    
                                    <th scope="col"
                                        class="py-3 text-left text-xs justify-end font-medium text-gray-500 uppercase tracking-wider">
                                        Periode
                                            <label class="flex">
                                                
                                                <select class="block py-2 border border-gray-300 bg-white rounded-md overflow-y:scroll shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                    v-model="bulan" @change="setPeriode()">
                                                    <option value="" selected disabled>Pilih Bulan</option>
                                                    <option value="" selected>Semua</option>
                                                    <option v-for="bulan in month" :key="bulan.index" :value="bulan.index">{{bulan.nama}}</option>
                                                </select>     
                                                <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                    v-model="tahun" >
                                                    <option value="" disabled selected>Pilih Tahun</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                </select>    
                                            </label>
                                    </th>
                                    <th scope="col"
                                        class="py-3 text-left text-xs font-medium text-gray-500 uppercase">>
                                        <approval :role="role" :tims="tims" :pernum="pernum" :penilaianTims="penilaianTims" :indexKriterias="indexKriterias" :penilaianDetails="penilaianDetails" :kriterias="kriterias" />
                                    </th>
                                                                      
                                </tr>
                        </table>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="border-t-2">
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No
                                    </th>                                     
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        v-if="$page.props.user.role=='admin'">
                                        Nama Tim
                                    </th>                                    
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Penilai
                                    </th>                                   
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tim 5P/Unit yg Dinilai
                                    </th>                                    
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Penilaian
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Periode
                                    </th>
                                    <th scope="col"
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                        v-if="$page.props.user.role=='admin' "> 
                                        Status
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Detail Nilai</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-if="data.dataPenilaian < 1">
                                    <td class="px-3 py-4 whitespace-nowrap border-r-2" colspan="8">
                                            <div class="flex items-center text-center">
                                                Tidak Ada Penilaian
                                            </div>
                                    </td> 
                                </tr>
                                <tr v-for="(penilaian, index) in displayedPosts" :key="penilaian.id">
                                        <td class="px-3 py-4 whitespace-nowrap border-r-2">
                                            <div class="flex items-center">
                                                {{ ((page*perPage) - perPage + index)+1 }}
                                            </div>
                                        </td>                                    
                                        <td class="px-3 py-4 whitespace-nowrap" v-if="$page.props.user.role=='admin'">
                                            <div class="flex items-center">
                                                {{ penilaian.nama_tim }}
                                            </div>
                                        </td> 
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                {{ penilaian.karyawan.nama }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                {{ penilaian.tim_unit.nama }}
                                            </div>
                                        </td>                                                                        
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                {{ penilaian.tgl }}
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                {{new Date(penilaian.periode).getMonth()+1 }}/{{new Date(penilaian.periode).getFullYear()}}
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap" v-if="$page.props.user.role=='admin'">
                                            <div class="flex items-center text-green-600" v-if="penilaian.approve == true">
                                                Sudah difinalisasi
                                            </div>
                                            <div class="flex items-center text-red-600" v-if="penilaian.approve == false">
                                                Belum difinalisasi
                                            </div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-right flex text-sm font-medium">
                                            <span><blue-button href="#" @click.prevent="openNilai(penilaian)">Show Nilai</blue-button></span>
                                        </td>
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                        <div class="justify-center object-center items-center content-center">
                            <nav class="pagination">
                                <ul class="flex">
                                    <li class="page-item px-2">
                                        <button class="page-link" v-if="page != 1" @click="page = 1" > First </button>
                                    </li>
                                    <li class="page-item px-2">
                                        <button class="page-link" v-if="page != 1" @click="page--" > Previous </button>
                                    </li>
                                    <li class="page-item px-2">
                                        <button class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" :key="pageNumber" @click="page = pageNumber" :class="{'focus:ring-offset-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2': page==pageNumber}"> {{pageNumber}} </button>
                                    </li>
                                    <li class="page-item px-2">
                                        <button @click="page++" v-if="page < pages.length" class="page-link"> Next </button>
                                    </li>
                                    <li class="page-item px-2">
                                        <button class="page-link" v-if="page < pages.length"  @click="page = pages.length" > Last </button>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                


        <jet-dialog-modal :show="detailNilai" @close="closeModal" :max-width="maxWidth">
            <template #title>
                Daftar Nilai 5P/Unit dari {{this.selectedPenilaian.tim_unit.nama}}
            </template>

            <template #content>
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
                                                Kriteria
                                            </th>                                   
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Sub Kriteria
                                            </th>                                    
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Nilai
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Status
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Rekomendasi
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Foto
                                            </th>
                                            <th scope="col" class="relative px-6 py-3">
                                                    <span class="sr-only">Detail Nilai</span>
                                            </th>                                                           
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="penilaian in form.listNilai" :key="penilaian.id">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ penilaian.kriteria.nama }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ penilaian.kriteria.sub_kriteria }}
                                                </div>
                                            </td>                                                                        
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{penilaian.nilai}}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="py-3 text-left text-xs tracking-wider options" style="vertical-align:middle">
                                                    {{ penilaian.status }}
                                                </div>
                                            </td>                                             
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="py-3 text-left text-xs tracking-wider options" style="vertical-align:middle">
                                                    {{ penilaian.rekomendasi }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ penilaian.foto }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center" v-if="$page.props.user.role == 'admin'">
                                                    
                                                    <span><jet-button  href="#" @click.prevent="editConfirmation(penilaian)">Edit Nilai</jet-button></span>
                                                </div>
                                                <div v-if="$page.props.user.role == 'user'" class="flex items-center" >
                                                    <span><jet-button v-if="$page.props.user.pernum == penilaian.penilaian.pernum && new Date(penilaian.penilaian.periode).getMonth() == setBulan(1) && new Date(penilaian.penilaian.periode).getFullYear() == new Date(today).getFullYear() || new Date(penilaian.penilaian.periode).getMonth() == new Date(today).getMonth() && new Date(penilaian.penilaian.periode).getFullYear() == new Date(today).getFullYear()" href="#" @click.prevent="editConfirmation(penilaian)">Edit Nilai</jet-button></span>
                                                </div>
                                            </td>                                                            
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    Nilai Total :
                                                </div>
                                            </td>
                                            <td >
                                                <div class="flex items-center">
                                                    {{this.nilaiTotal}}
                                                </div>
                                            </td>
                                        </tr>


                                            <!-- More people... -->
                                    </tbody>
                                </table>
                                <div v-if="$page.props.user.pernum == this.selectedPenilaian.pernum || $page.props.user.role == 'admin'">
                                    <green-button v-if="form.listNilai.length < 1" @click="tambahData()" class="w-1/4">
                                        Tambah
                                    </green-button>
                                </div>
                                
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

        <jet-dialog-modal :show="editModal" @close="editModal==false">
            <template #title>
                Edit Penilaian
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="edit.nilai"
                                @keyup.enter="update" />

                    <jet-input-error :message="edit.errors.nilai" class="mt-2" />                    
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Keterangan"
                                ref="keterangan"
                                v-model="edit.status"
                                rows="4"
                                cols="50">
                    </textarea>
                    

                    <jet-input-error :message="edit.errors.status" class="mt-2" />                    
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Rekomendasi"
                                ref="rekomendasi"
                                v-model="edit.rekomendasi"
                                rows="4"
                                cols="50">
                    </textarea>
                    <jet-input-error :message="edit.errors.rekomendasi" class="mt-2" />                    
                    <input type="file"
                        ref="foto"
                        @change="updateFotoPreview()"
                        disabled > <label class="text-red-500">Fitur ini akan hadir segera</label>

                    <jet-label for="foto" value="Foto" />                                            
                    <jet-input-error :message="edit.errors.foto" class="mt-2" />                                

                    <div v-show="preview">
                        <span class="block w-20 h-20 rounded-full"
                            :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview + '\');'">
                        </span>
                    </div>
                </div>               
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="editModal = false">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': edit.processing }" :disabled="edit.processing">
                        Edit
                    </jet-button>
                </div>
            </template>
        </jet-dialog-modal>


    </div>
    
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import BlueButton from '@/Components/BlueButton.vue'
import GreenButton from '@/Components/GreenButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import {TabsWrapper, TabsContent, Tab} from '@ocrv/vue-tailwind-tabs'
import Approval from './Approval.vue'
import Pagination from '@/Jetstream/Pagination'
import SlidingPagination from 'vue-sliding-pagination'


export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetCheckbox,
        BlueButton,
        TabsWrapper,
        TabsContent,
        Tab,
        Approval,
        Pagination,
        SlidingPagination,
        BlueButton,
        GreenButton,

    },

    props: {
        penilaians:Array,
        penilaianDetails:Array,
        kriterias:Array,
        tims:Array,
        pernum:BigInt,
        role:String,
        timList:Array,
        timUnits:Array,
        term:String,
        periode:String,
        penilaianTims:Array,
        indexKriterias:Array,
    },
    computed:{
        displayedPosts:function() {
			return this.paginate(this.data.dataPenilaian);
		}
    },
    watch: {
		posts () {
			this.setPages();
		}
	},
	created(){        
		this.getData();
        this.setPages();
        
	},

    data() {
        return {
            showApproval:false,
            tim_yg_dinilai:[],
            detailNilai: false,
            editModal:false,
            selectedPenilaian:{},
            editObject:{},
            nilaiTotal:0,
            maxWidth:'2md',
            preview:'',
            bulan:'',
            page: 1,
			perPage: 10,
            tahun:2022,
            today:'',
            TimPenilai:{},
            
			pages: [],


            
            month:[
                {
                    nama:'Januari',
                },{
                    nama:'Februari',
                },{
                    nama:'Maret',
                },{
                    nama:'April',
                    
                },{
                    nama:'Mei',
                    
                },{
                    nama:'Juni',
                    
                },{
                    nama:'Juli',
                    
                },{
                    nama:'Agustus',
                    
                },{
                    nama:'September',
                    
                },{
                    nama:'Oktober',
                    
                },{
                    nama:'November',
                    
                },{
                    nama:'Desember',
                    
                },     
            ],
            form: this.$inertia.form({
                listNilai: [],
                periode:'',
                
            }),
            data:this.$inertia.form({
                dataPenilaian:[],
            }),
            edit:this.$inertia.form({
                penilaian_id:'',
                kriteria:'',
                nilai:'',
                foto:'',
                status:'',
                rekomendasi:''
            }),
        }
    },

    methods: {
        openNilai(penilaian){
            this.detailNilai = true;
            this.selectedPenilaian = penilaian;
            var j=0;
            var nilaiTotal=0;
            for(var index=0;index<=this.penilaianDetails.length-1;index++){
                if(this.penilaianDetails[index].penilaian_id == penilaian.id){
                    this.form.listNilai[j] = this.penilaianDetails[index];
                    nilaiTotal = nilaiTotal + this.form.listNilai[j].nilai;
                    j++;
                    
                }
            }
            this.nilaiTotal = parseFloat((nilaiTotal).toFixed(2));
            var date = new Date();
            var output = '';
            if(date.getMonth() < 9 && date.getMonth()>=0){
                var output = date.getFullYear() + '-' + '0' + (date.getMonth() + 1) + '-' + '01';
            }else if(date.getMonth() >= 9){
                var output = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + '01';
            }
            this.today = output;

        },
        setBulan(decrement){
            var date = new Date();
            var x = date.getMonth()-decrement;
            if(x < 0){
                x = 12-decrement;
            }
            return x;
        },
        getData(){
            this.getTimObject();
            var x = 0;
            if(this.role == 'admin'){
                this.data.dataPenilaian = this.penilaians;
                this.getTimPenilai();
            }
            else if(this.role == 'user'){
                for(var index=0;index<this.penilaians.length;index++){
                    for(var j=0;j<this.tims.length;j++){
                        if(this.tims[j].tim_id == this.TimPenilai.tim_id){
                            if(this.tims[j].karyawan.pernum == this.penilaians[index].pernum && this.penilaians[index].approve == false){
                                this.data.dataPenilaian[x] = this.penilaians[index];
                                x++;
                            }
                        }
                    }
                }
                this.getTim();
            }
            
        },
        getTimObject(){
            for (let index = 0; index < this.tims.length; index++) {
                if(this.tims[index].karyawan.pernum == this.pernum){
                    this.TimPenilai = this.tims[index];
                }
                
            }
            for(var i =0;i<this.month.length;i++){
                this.month[i].index = i;
            }
            if(this.periode != null){
                var date = new Date(this.periode);
                this.bulan = date.getMonth();
                this.tahun = date.getFullYear();
            }
        },
        

        getTimPenilai(){
            for(var index=0;index<=this.penilaians.length-1;index++){
                for(var j=0;j<=this.tims.length-1;j++){
                    if(this.penilaians[index].pernum == this.tims[j].karyawan.pernum){
                        this.penilaians[index].nama_tim = this.tims[j].tim.nama;
                    }
                }
            }
        },
    
        editConfirmation(penilaian){        
            this.editModal = true;
            this.editObject = penilaian;
            this.edit.penilaian_id = penilaian.penilaian.id;
            this.edit.kriteria = penilaian.kriteria.id;
            this.edit.nilai = penilaian.nilai;
            this.edit.status = penilaian.status;
            this.edit.rekomendasi = penilaian.rekomendasi;
            this.edit.foto = penilaian.foto;
            this.preview = penilaian.foto;
        },
        update() {
            this.edit.put(route('penilaianDetail.update', this.editObject.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.editModal = false;
                    this.edit.reset();
                    this.openNilai(this.selectedPenilaian);
                },
            })
        },

        updateFotoPreview(){
                const reader = new FileReader();

                this.edit.foto = this.$refs[foto].files[0];

                reader.onload = (e) => {
                    this.preview = e.target.result;
                };
                

                reader.readAsDataURL(this.$refs[foto].files[0]);
                
        },

        setPeriode(){
            if(this.bulan < 9 && this.bulan>=0){
                var output = this.tahun + '-' + '0' + (this.bulan+1) + '-' + '01';
            }else if(this.bulan >= 9){
                var output = this.tahun + '-' + (this.bulan+1) + '-' + '01';
            }
            this.form.periode = output;
            this.searchPeriode();
        },

        closeModal() {
            this.detailNilai = false;
            this.editModal = false;
            this.form.reset();
            this.nilaiTotal = 0;
        },
        searchTerm(){
            if(this.term == 'semua' || this.term == ''){
                this.$inertia.get(this.route('penilaian.index', {term: '', periode:this.form.periode}, {preserveState:true, replace:true}));
                this.getData();
            }else{
                this.$inertia.get(this.route('penilaian.index', {term: this.term, periode:this.form.periode}, {preserveState:true, replace:true}));
                this.getData();
            }
            
        },
        searchPeriode(){
            if(this.bulan == 'semua' || this.bulan == ''){
                this.$inertia.get(this.route('penilaian.index', {term:this.term, periode: ''}, {preserveState:true ,replace:true}));
                this.getData();
            }else{
                this.$inertia.get(this.route('penilaian.index', {term:this.term, periode: this.form.periode}, {preserveState:true ,replace:true}));
                this.getData();
            }
        },
        getTim(){
            var x=0;
            if(this.role=='user'){
                for (let i = 0; i < this.penilaianTims.length; i++) {
                    for (let j = 0; j < this.tims.length; j++) {
                        if(this.tims[j].karyawan.pernum == this.pernum){
                            if(this.penilaianTims[i].tim_id == this.tims[j].tim_id){
                                this.tim_yg_dinilai[x] = this.penilaianTims[i];
                                x++;
                            }
                        }
                        
                    }
                }
            }
        },
        tambahData(){
            this.$inertia.get(this.route('penilaianDetail.index', {penilaian_id:this.selectedPenilaian.id, pernum:this.selectedPenilaian.pernum}))
        },
		setPages () {
			let numberOfPages = Math.ceil(this.data.dataPenilaian.length / this.perPage);
			for (let index = 1; index <= numberOfPages; index++) {
				this.pages.push(index);
			}
		},
		paginate (posts) {
			let page = this.page;
			let perPage = this.perPage;
			let from = (page * perPage) - perPage;
			let to = (page * perPage);
			return  posts.slice(from, to);
		}

    },
    filters: {
		trimWords(value){
			return value.split(" ").splice(0,20).join(" ") + '...';
		}
	}
}
</script>

<style scoped>


    .options{
        white-space: pre-wrap;
        word-wrap: break-word;
        font-family: inherit;
    }
    .table{
        font-size: 13px;        
        box-sizing: border-box;
        padding: 0;
        -webkit-box-sizing: border-box;
        width: 100%;
        margin: 0 auto;
        clear: both;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-bordered{
        border: 1px solid #f4f4f4;
        overflow-x: hidden;
        overflow-y: auto;
        font-family: "Poppins", sans-serif;
        font-weight: 400;
        line-height: 1.625;
        color: #666;
        -webkit-font-smoothing: antialiased;
        box-sizing: border-box;
    }
    .page-link {
	    display: inline-block;
    }
    .page-link {
        font-size: 20px;
        color: #29b3ed;
        font-weight: 500;
    }
    .offset{
        width: 1000px !important;
        margin: 20px auto;  
    }

    .pagination {
        list-style: none;
        margin: 0;
        padding: 0;
        text-align: center;
    }
    .page-link:not(:disabled):not(.disabled) {
        cursor: pointer;
    }
    button{
        background: #d1e5fa;
        margin: .25rem;
        padding: .25rem .5rem;
        border-radius: 4px;
        text-decoration: none;
        position: relative;
        display: block;
        color: #65a2e9;
    }
    li {
        display: inline-block;
        border: 1px solid #D5D5D5;
        box-sizing: border-box;
        margin-left: -1px; 
    }
    button.page-link {
        font-size: 20px;
        color: #29b3ed;
        font-weight: 500;
        border: black;
        
    }
    button.page-link {
        display: inline-block;
    
    }
            a{
                background: #65a2e9;
                margin: .25rem;
                padding: .25rem .5rem;
                border-radius: 4px;
                text-decoration: none;
                position: relative;
                display: block;
                color: #d1e5fa;
            }    
    
</style>




