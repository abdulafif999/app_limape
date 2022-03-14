<template>
    <div>
        <green-button @click="createPenilaian">
            Tambah Penilaian
        </green-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingPenilaian" @close="closeModal" :max-width="maxWidth">
            <template #title>
                Create Penilaian
            </template>
        
            <template #content>
                <div class="sm:-my-px sm:ml-1 sm:flex bg-gray mt-12 mb-14">
                            <div v-if="$page.props.user.role==='admin'">
                                <div>
                                    <label class="text-gray-900">
                                        Penilai
                                        <div class="items-start mx-auto my-auto">
                                            <jet-input v-model="member" @input="filterMember()" class="w-10/12 ml-2"></jet-input>
                                            <div v-if="memberList" class="options border-transparent ml-2" ref="karyawan">
                                                <ul>
                                                    <li v-for="karyawan in memberList" :key="karyawan.pernum" class="hover:bg-green-600" @click="setMember(karyawan)">
                                                        {{karyawan.nama}} - {{karyawan.nama_tim}}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <jet-input-error :message="form.errors.pernum" class="mt-2" />
                                    </label>

                                    <label class="text-gray-700">
                                        Area Penilaian
                                        <select class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                            v-model="form.tim_unit_id">
                                            <option value="" disabled selected>Pilih Tim 5P/Unit</option>
                                            <option v-for="tim in form1.timList" :key="tim.tim_unit_id" :value="tim.tim_unit_id">{{tim.tim_unit.nama}}</option>
                                        </select>
                                        <jet-input-error :message="form.errors.tim_unit_id" class="mt-2" />  
                                    </label>

                                    <label class="text-gray-700">Tanggal Penilaian
                                        <input type="date" class="block w-52 py-2 ml-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" placeholder="Tanggal Penilaian"
                                                    ref="tgl"
                                                    v-model="form.tgl"
                                                    @keyup.enter="create" />

                                        <jet-input-error :message="form.errors.tgl" class="mt-2" />
                                    </label>
                                    <div class="flex">
                                        <label class="text-gray-900">
                                            Periode
                                            <select class="block py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="bulan" @change="setPeriode()">
                                                <option value="" disabled selected>Pilih Bulan</option>
                                                <option v-for="bulan in month" :key="bulan.index" :value="bulan.index">{{bulan.nama}}</option>
                                            </select>     
                                        </label>
                                        <label class="text-gray-900">
                                            Tahun
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="tahun">
                                                <option value="" disabled selected>Pilih Tahun</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                            </select>    
                                        </label>          
                                    </div>                
                                    <jet-input-error :message="form.errors.periode" class="mt-2" />

                                </div>
                                    
                                    
                            </div>
                            <div v-else-if="$page.props.user.role === 'user'" :v-on:show="setPenilaianData()">
                                <div :v-on:show="getPenilaianTim($page.props.user.pernum)" >
                                    <div>
                                    <label class="text-gray-700" >
                                        Area Penilaian
                                        <select class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                            v-model="form.tim_unit_id">
                                            <option value="" disabled selected>Pilih Tim 5P/Unit</option>
                                            <option v-for="tim in form1.timList" :key="tim.tim_unit_id" :value="tim.tim_unit_id">{{tim.tim_unit.nama}}</option>
                                        </select>
                                        <jet-input-error :message="form.errors.tim_unit_id" class="mt-2" />  
                                    </label>   
                                    <label class="text-gray-700">Tanggal Penilaian
                                        <jet-input type="date" class="block w-52 py-2 ml-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" placeholder="Tanggal Penilaian"
                                                    ref="tgl"
                                                    v-model="form.tgl"
                                                    @keyup.enter="create" />

                                        <jet-input-error :message="form.errors.tgl" class="mt-2" />
                                    </label>
                                    <div class="flex ml-2">
                                        <label class="text-gray-900">
                                            Periode
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="bulan" @change="setPeriode()">
                                                <option value="" disabled selected>Pilih Bulan</option>
                                                <option v-for="bulan in periode_bulan" :key="bulan.index" :value="bulan.index">{{bulan.nama}}</option>
                                            </select>     
                                        </label>
                                        <label class="text-gray-900">
                                            Tahun
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="tahun">
                                                <option value="" disabled selected>Pilih Tahun</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                                <option value="2023">2023</option>
                                                <option value="2024">2024</option>
                                            </select>    
                                        </label>          
                                    </div>                
                                    <jet-input-error :message="form.errors.periode" class="mt-2" />

                                </div>
                                                                     
                                </div>
                            </div>
                </div>


                <div v-if="showNilai == true" :v-bind="showNilai">
                    <div class="flex flex-col">
                        <div class="py-my-6 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 table-bordered table">
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
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="penilaian in listNilai" :key="penilaian.id">
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
                                            <td class="px-6 py-4 whitespace-nowrap options">
                                                <div class="py-3 text-left text-xs tracking-wider options" style="vertical-align:middle">
                                                    {{ penilaian.rekomendasi }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap options">
                                                <div class="flex items-center">
                                                    {{ penilaian.foto }}
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="closeModal">
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
import { Inertia } from '@inertiajs/inertia'
import CreatePenilaianDetail from './CreatePenilaianDetail.vue'
import GreenButton from '@/Components/GreenButton.vue'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        CreatePenilaianDetail,
        GreenButton,
    },

    data() {
        return {
            creatingPenilaian: false,
            showNilai:false,
            listTim:[],
            member:'',
            memberList:[],
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
            periode_bulan:[],
            bulan:'',
            tahun:2022,
            
            form: this.$inertia.form({
                tgl: '',
                pernum: '',
                tim_unit_id: '',
                periode:''
            }), 
            form1: this.$inertia.form({
                timList: [],
            }),
            listNilai:[],
            maxWidth:'2xl',
                      
        }
    },
    props:{
        tims:Array,
        penilaians:Array,
        penilaianTims:Array,
        penilaianDetails:Array,
        pernum:String,
        karyawans:Array,
    },
    mounted(){
        this.getTim();
    },


    methods: {
        getTim(){
            for(var i=0;i<this.karyawans.length;i++){
                for(var j=0;j<this.tims.length;j++){
                    if(this.karyawans[i].nip == this.tims[j].nip){
                        this.karyawans[i].nama_tim = this.tims[j].tim.nama
                    }
                }
            }
        },
        createPenilaian() {
            this.creatingPenilaian = true;
            this.getPeriode();

        },
        getPenilaianTim(pernum){
            this.form1.reset();
            this.listTim = [];
            var k=0;

            for(var index=0;index<=this.penilaianTims.length-1;index++){
                for(var j=0;j<=this.tims.length-1;j++){
                    if (pernum == this.tims[j].karyawan.pernum && this.penilaianTims[index].tim_id == this.tims[j].tim_id) {
                        this.form1.timList[k] = this.penilaianTims[index];
                        k++;
                    }
                }
            }
        },
        setPenilaianData(){

            this.form.pernum = this.pernum;
            this.getPenilaianTim(this.pernum);


        },
        setPeriode(){
            if(this.bulan < 9 && this.bulan>=0){
                var output = this.tahun + '-' + '0' + (this.bulan + 1) + '-' + '01';
            }else if(this.bulan >= 9){
                var output = this.tahun + '-' + (this.bulan + 1) + '-' + '01';
            }
            this.form.periode = output;
        },

        create() {
            var check = this.checkPenilaian();

            if(check){
                this.showNilai =true;
                this.maxWidth = '3xl';
                this.openNilai();
            }else{ 
                this.showNilai= false;
                this.form.post(route('penilaian.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.form.closeModal();
                    this.form.reset();
                },
                })
            }
        },
        openNilai(){
            var j=0;
            for(var index=0;index<this.penilaianDetails.length;index++){
                if(this.penilaianDetails[index].penilaian.tim_unit_id == this.form.tim_unit_id && this.penilaianDetails[index].penilaian.periode == this.form.periode && this.penilaianDetails[index].penilaian.pernum == this.form.pernum){
                    this.listNilai[j] = this.penilaianDetails[index];
                    j++;
                    
                }
            }
        },
        checkPenilaian(){
            var exist = this.penilaians.some(penilaian => penilaian.tim_unit_id == this.form.tim_unit_id && penilaian.pernum == this.form.pernum && penilaian.periode == this.form.periode);
            return exist;
        },

        getPeriode(){
            var date = new Date();
            var batas_awal;
            var batas_akhir = date.getMonth();
            var counter = 0;
            var x=0;

            for (let i = 0; i < this.month.length; i++) {
                this.month[i].index = i;
                
            }
            
            for(batas_awal = date.getMonth()-1;batas_awal<=batas_akhir;batas_awal++){
                if(batas_awal < 0){
                    counter = 12 + batas_awal;
                    this.periode_bulan[x] = this.month[counter];
                    this.periode_bulan[x].index = counter;
                    x++;
                }
                else{
                    this.periode_bulan[x] = this.month[batas_awal];
                    this.periode_bulan[x].index = batas_awal;
                    x++;
                }
                
            }
            
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
            this.form.pernum = karyawan.pernum;
            this.memberList = [];
            this.getPenilaianTim(karyawan.pernum);
        },

        closeModal() {
            this.creatingPenilaian = false
            this.form.clearErrors()
            this.form.reset()

        }, 
    }
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