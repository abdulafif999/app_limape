<template>
    <div>
        <div v-if="$page.props.user.role == 'user' ">
            <green-button @click="createPenilaian">
                Aproval Nilai
            </green-button>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingPenilaian" @close="closeModal" :max-width="maxWidth">
            <template #title>
                Menu Approv Nilai
            </template>
        
            <template #content>
                <div class="sm:-my-px sm:ml-1 sm:flex bg-gray mt-12 mb-14">
                    <div class="flex">
                                    <label class="text-gray-700">
                                        Tim yang Dinilai
                                        <select class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                            v-model="form.tim_unit_id">
                                            <option value="" disabled selected>Pilih Tim 5P/Unit</option>
                                            <option v-for="tim in tim_yg_dinilai" :key="tim.tim_unit_id" :value="tim.tim_unit.id">{{tim.tim_unit.nama}}</option>
                                        </select>
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
                                            </select>    
                                        </label>          
                                    </div>                
                                    <label>
                                        .
                                    <jet-button @click="showApproval" class="h-10 ml-6">
                                        Lihat
                                    </jet-button>                                    
                                    </label>
                            </div>
                </div>

                <div v-if="show == true" :v-bind="show">
                    <div class="flex flex-col" :v-bind="listNilai">
                        <div class="py-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200" v-for="(kriteria, index1) in header" :key="kriteria.nama">
                                        <thead class="bg-gray-50" >
                                            <tr>                                   
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Anggota
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" v-for="sub_kriteria in kriteria.sub_kriteria" :key="sub_kriteria">
                                                    {{kriteria.kriteria}} {{sub_kriteria}}
                                                </th>           
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200" >
                                            <tr v-for="(anggota, index) in listAnggota" :key="anggota.karyawan.pernum">                                                                         
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        {{anggota.karyawan.nama}}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap" v-for="nilai in listNilai[index].kriteria[index1].nilai" :key="nilai">
                                                    <div class="flex items-center">
                                                        {{nilai}}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">

                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap"  v-for="deviasi in nilaiDeviasi[index1].nilai" :key="deviasi">
                                                    <div class="flex items-center" :class="{ 'text-red-600' : deviasi >= 20, 'text-green-700' : deviasi < 20 }">
                                                        {{deviasi}}
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
                <div v-if="approved==true" class="bg-green-200 border-green-600 text-green-600 text-left border-l-4 p-4" role="alert" :v-bind="approved">
                    <p class="font-bold">
                        Nilai Sudah di Approve
                    </p>
                </div>


            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <green-button class="ml-2" @click="update" :class="{ 'opacity-25': penilaian.processing }" :disabled="penilaian.processing">
                        Approve
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
import GreenButton from '@/Components/YellowButton.vue'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        GreenButton,
    },

    data() {
        return {
            creatingPenilaian: false,
            show:false,
            approved:false,
            tim_yg_dinilai:[] ,
            listAnggota:[],
            nilaiDeviasi:[],
            min_temp:[],
            max_temp:[],
            listNilai:[],
            sementara:[],
            header:[],
            
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
            tahun:2021,
            
            form: this.$inertia.form({
                tim_unit_id: '',
                periode:''
            }),          

            penilaian:this.$inertia.form({
                penilaian_id:[],
            }),
            maxWidth:'3xl',
                      
        }
    },
    props:{
        tims:Array,
        penilaianTims:Array,
        pernum:BigInt,
        role:String,
        indexKriterias:Array,
        penilaianDetails:Array,
    },
    mounted(){
        this.getTim();
    },

    methods: {
        createPenilaian() {
            this.creatingPenilaian = true;

        },

        getTim(){
            var x=0;
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
            this.getPeriode();
        },
        getAnggota(){
            var g=0;
            for (let j = 0; j < this.tims.length; j++) {
                if(this.tims[j].karyawan.pernum == this.pernum){
                    for (let index = 0; index < this.tims.length; index++) {
                        if(this.tims[j].tim_id == this.tims[index].tim_id){
                            this.listAnggota[g] = this.tims[index];
                            g++;
                        }
                    }
                    
                }
            }
        },
        

        setPeriode(){
            if(this.bulan < 9 && this.bulan>=0){
                var output = this.tahun + '-' + '0' + this.bulan+1 + '-' + '01';
            }else if(this.bulan >= 9){
                var output = this.tahun + '-' + this.bulan+1 + '-' + '01';
            }
            this.form.periode = output;
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
                    x++
                }
                else{
                    this.periode_bulan[x] = this.month[batas_awal];
                    this.periode_bulan[x].index = batas_awal;
                    x++;
                }
                
            }
            
        },

        showApproval(){
            this.listNilai = [];
            this.nilaiDeviasi = [];
            this.header = [];
            this.listAnggota = [];
            this.show = true;
            this.getAnggota();
            var kriteria_temp = [];
            var getP = ['P1', 'P2', 'P3', 'P4'];

            for (let index = 0; index < this.listAnggota.length; index++) {
                var x = 0;
                var y = 0;
                kriteria_temp[x] = {};
                for(var j=0;j < this.penilaianDetails.length;j++){
                    var periode = new Date(this.penilaianDetails[j].penilaian.periode);
                    if(this.penilaianDetails[j].penilaian.tim_unit_id == this.form.tim_unit_id
                    && this.bulan == periode.getMonth() && this.tahun == periode.getFullYear()){
                        if(this.penilaianDetails[j].penilaian.pernum == this.listAnggota[index].karyawan.pernum){
                                if(this.penilaianDetails[j].penilaian.approve == false){
                                    this.approved = false;
                                    kriteria_temp[x] = this.penilaianDetails[j];
                                    x++;
                                }else if(this.penilaianDetails[j].penilaian.approve == true){
                                    this.listNilai = [];
                                    this.listAnggota = [];
                                    this.approved = true;
                                }
                                
                        }
                        else{
                            kriteria_temp[y] = {};
                            y++;
                        }
                    }
                }

                this.listNilai[index] = {};
                this.listNilai[index].kriteria = []
                for(var a = 0;a < getP.length; a++){
                    var w=0;
                    this.header[a] = {};
                    this.listNilai[index].kriteria[a] = {};
                    this.listNilai[index].kriteria[a].nama = '';
                    this.listNilai[index].kriteria[a].sub_kriteria = [];
                    this.listNilai[index].kriteria[a].nilai = [];
                    this.header[a].kriteria = '';
                    this.header[a].sub_kriteria = [];
                    for (let m = 0; m < kriteria_temp.length; m++) {
                        if(kriteria_temp[m].kriteria.nama == getP[a]){
                            this.listNilai[index].kriteria[a].nama = kriteria_temp[m].kriteria.nama;
                            this.listNilai[index].kriteria[a].sub_kriteria[w] = kriteria_temp[m].kriteria.sub_kriteria;
                            this.listNilai[index].kriteria[a].nilai[w] = kriteria_temp[m].nilai;
                            this.header[a].kriteria = kriteria_temp[m].kriteria.nama;
                            this.header[a].sub_kriteria[w] = kriteria_temp[m].kriteria.sub_kriteria;
                            this.penilaian.penilaian_id[index] = kriteria_temp[m].penilaian_id;
                            w++;
                        }
                    }                                                    
                        
                }
            }
            this.getDeviasi();
                
                
        },

        getDeviasi(){
            var max = [];
            var min = [];
            for(var j =0;j<1;j++){
                for (let k = 0; k < this.listNilai[j].kriteria.length; k++) {
                    max[k] = {};
                    min[k] = {};
                    max[k].nilai = [];
                    min[k].nilai = [];
                    for (let l = 0; l < this.listNilai[j].kriteria[k].nilai.length; l++) {
                        max[k].nilai[l] = this.listNilai[j].kriteria[k].nilai[l];                                    
                        min[k].nilai[l] = this.listNilai[j].kriteria[k].nilai[l];
                    }
                }
            }
            this.max_temp = max;
            this.min_temp = min;

            for (let index = 1; index < this.listNilai.length; index++) {
                for (let i = 0; i < max.length; i++) {
                    for (let x = 0; x < max[i].nilai.length; x++) {
                        if(this.listNilai[index].kriteria[i].nilai[x] >= max[i].nilai[x]){
                            max[i].nilai[x] = this.listNilai[index].kriteria[i].nilai[x];
                        }else if(this.listNilai[index].kriteria[i].nilai[x] < min[i].nilai[x]){
                            min[i].nilai[x] = this.listNilai[index].kriteria[i].nilai[x];
                        }
                        
                    }
                    
                }
            }                    

            for (let n = 0; n < max.length; n++) {
                this.nilaiDeviasi[n] = {};
                this.nilaiDeviasi[n].nilai = [];
                for (let o = 0; o < max[n].nilai.length; o++) {
                    this.nilaiDeviasi[n].nilai[o] = (max[n].nilai[o] - min[n].nilai[o]);
                    
                }
                
            }

        },

        update() {
            this.penilaian.put(route('penilaian.update', this.penilaian.penilaian_id[0]), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                },
            })
        },

        closeModal() {
            this.creatingPenilaian = false
            this.form.clearErrors();
            this.penilaian.reset();
            this.form.reset();

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