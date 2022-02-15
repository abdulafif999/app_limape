<template>
    <div>
        <div v-if="$page.props.user.role == 'user' ">
            <green-button @click="createPenilaian">
                Finalisasi Nilai
            </green-button>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingPenilaian" @close="closeModal" :max-width="maxWidth">
            <template #title>
                Menu Finalisasi Nilai
            </template>
        
            <template #content>
                <div class="sm:-my-px sm:ml-1 sm:flex bg-gray mt-12 mb-14">
                    <div class="flex">
                                    <label class="text-gray-700">
                                        Area Penilaian
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
                                                v-model="tahun" >
                                                <option value="" disabled>Pilih Tahun</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>    
                                        </label>          
                                    </div>                
                                    <label>
                                        .
                                    <jet-button @click="showApproval" class="h-10 ml-6" :class="{ 'opacity-25': list.processing }" :disabled="list.processing">
                                        Lihat
                                    </jet-button>                                    
                                    </label>
                            </div>
                </div>

                <div v-if="!approved && !blankAnggota && show" :v-bind="[show, list.listNilai, blankAnggota, approved]">
                    <div class="flex flex-col" :v-bind="[list.listNilai, nilai.nilaiDeviasi]">
                        <div class="py-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50" >
                                            <tr>                                   
                                                <th scope="col" 
                                                    class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Anggota
                                                </th>
                                                <th scope="col"
                                                    class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" v-for="kriteria in kriterias" :key="kriteria.nama">
                                                    {{kriteria.kode}}
                                                </th>           
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200" >
                                            <tr v-for="(anggota, index) in listAnggota" :key="anggota.pernum">
                                                <td class="px-2 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        {{anggota.karyawan.nama}}
                                                    </div>
                                                </td>
                                                <td class="px-2 py-4 whitespace-nowrap" v-for="nilai in showNilai[index].detail.slice(0, kriterias.length)" v-bind:key="nilai.nilai">
                                                    <div class="flex items-center">
                                                        {{nilai.nilai}}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="border-t-2">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center text-right">
                                                        Nilai Deviasi
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-left" v-for="deviasi in showDeviasi" v-bind:key="deviasi">
                                                    <div class="flex items-center justify-start" :class="{ 'text-red-600' : deviasi >= 20, 'text-green-700' : deviasi < 20 }">
                                                        {{deviasi}}
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div class="px-4 bg-yellow-500  text-center" v-if="ketua">
                                    Jika salah satu Nilai Deviasi ada yang lebih atau sama dengan 20 maka penilaian tidak bisa difinalisasi
                                </div>
                            </div>
                            
                        </div>
                        

                    </div>
                </div>
                <div v-else-if="approved && !blankAnggota && !show" class="bg-green-200 border-green-600 text-left border-l-4 p-4" role="alert" :v-bind="[show, list.listNilai, blankAnggota, approved]">
                    <p class="font-bold">
                        Nilai Sudah difinalisasi
                    </p>
                </div>
                <div v-else-if="!approved && blankAnggota && !show" :v-bind="[show, list.listNilai, blankAnggota, approved]" class="bg-red-200 border-red-600 text-left border-l-4 p-4" role="alert">
                        Ada anggota yang belum menilai
                </div>
                <div v-if="showDeviasi==true && show==false" class="bg-red-200 border-red-600  text-left border-l-4 p-4" role="alert" :v-bind="[show, showDeviasi]">
                    <p class="font-bold">
                        Tidak bisa difinalisasi karena ada nilai deviasi diatas 20
                    </p>
                </div>


            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <green-button class="ml-2" @click="update" :class="{ 'opacity-25': penilaian.processing }" :disabled="penilaian.processing" v-if="ketua">
                        Finalisasi
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
            blankAnggota:false,
            ketua:false,
            showDeviasi:false,
            tim_yg_dinilai:[] ,
            listAnggota:[],
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
            tahun:'',
            
            form: this.$inertia.form({
                tim_unit_id: '',
                periode:''
            }),          

            penilaian:this.$inertia.form({
                penilaian_id:[],
            }),

            
            nilai:this.$inertia.form({
                nilaiDeviasi:[],
            }),

            list:this.$inertia.form({
                listNilai:[],
            }),
            maxWidth:'3xl',
            pengumuman:'',
                      
        }
    },
    props:{
        tims:Array,
        penilaianTims:Array,
        pernum:BigInt,
        role:String,
        indexKriterias:Array,
        penilaianDetails:Array,
        kriterias:Array,
    },
    computed:{
        showNilai:function(){
            return this.list.listNilai;
        },
        showDeviasi:function(){
            return this.nilai.nilaiDeviasi;
        }
    },
    created(){
        this.getTim();
    },
    watch: {
		listNilai () {
			this.showApproval();
            this.getDeviasi();
		}
	},

    methods: {
        createPenilaian() {
            this.creatingPenilaian = true;
            this.list.reset()
            var check = this.tims.some(check => check.karyawan.pernum == this.pernum && check.posisi == 'Ketua');
            if(check){
                this.ketua = true;
            }else{
                this.ketua = false;
            }
            var date = new Date();
            this.tahun = date.getFullYear();

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
            this.getKode();
        },
        getKode(){
            for (let index = 0; index < this.kriterias.length; index++) {
                var splitKode = this.kriterias[index].sub_kriteria.split(" ");
                var huruf = splitKode[0].charAt(0);
                var kode = this.kriterias[index].nama + '.'+ huruf + splitKode[1];
                this.kriterias[index].kode = kode;                
            }
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
                var output = this.tahun + '-' + '0' + (this.bulan+1) + '-' + '01';
            }else if(this.bulan >= 9){
                var output = this.tahun + '-' + (this.bulan+1) + '-' + '01';
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
            this.list.reset();
            this.penilaian.reset();
            this.nilai.reset();
            this.getAnggota();
            var checkingAnggota = [];
            let index = 0
            while(index < this.listAnggota.length) {
                var x = 0;
                this.list.listNilai[index] = {};
                this.list.listNilai[index].detail = []
                this.list.listNilai[index].pernum = this.listAnggota[index].karyawan.pernum
                var kriteria_temp = [];
                kriteria_temp[x] = {};
                for(var j=0;j < this.penilaianDetails.length;j++){
                    var periode = new Date(this.penilaianDetails[j].penilaian.periode);
                    if(this.bulan == periode.getMonth() && this.tahun == periode.getFullYear()){
                        if(this.penilaianDetails[j].penilaian.tim_unit_id == this.form.tim_unit_id){
                            if(this.penilaianDetails[j].penilaian.pernum == this.listAnggota[index].karyawan.pernum){
                                    if(this.penilaianDetails[j].penilaian.approve == false){
                                        this.approved = false;
                                        kriteria_temp[x] = this.penilaianDetails[j];
                                        this.penilaian.penilaian_id[index] = this.penilaianDetails[j].penilaian_id;
                                        x++;
                                    }else if(this.penilaianDetails[j].penilaian.approve == true){
                                        this.approved = true;

                                    }
                            }
                        }
                    }
                }
                
                if(kriteria_temp.length > 0 && !this.approved){
                    if(kriteria_temp.length == this.kriterias.length){
                        this.list.listNilai[index].detail = kriteria_temp;
                        if(this.list.listNilai[index].detail.length > this.kriterias.length){
                            this.list.listNilai[index].detail.length = this.kriterias.length
                        }
                        checkingAnggota[index] = 'show'
                    }else{
                        checkingAnggota[index] = 'blank'
                    }
                    
                }
                else if(this.approved){
                    checkingAnggota[index] = 'approved'
                }else if(!this.approved && kriteria_temp.length < 1){
                    checkingAnggota[index] = 'blank'
                }
                index++;
            }
            var anggotaBlank = checkingAnggota.some(check => check == 'blank');
            var checkApprove = checkingAnggota.some(check => check == 'approved');
            if(anggotaBlank && !checkApprove){
                this.blankAnggota = true;
                this.approved = false;
                this.show = false;
                this.showDeviasi = false;
                
            }else{
                if(!anggotaBlank && checkApprove){
                    this.approved = true;
                    this.blankAnggota = false;
                    this.show = false;
                    this.showDeviasi = false;
                }else if(!anggotaBlank && !checkApprove){
                    this.blankAnggota = false;
                    this.approved = false;
                    this.show = true;
                    this.showDeviasi = false;
                    this.getDeviasi();
                }
            }
            
        },

        getDeviasi(){
            var max = [];
            var min = [];
            this.nilai.reset();
            for(var j =0;j<1;j++){
                for (let k = 0; k < this.list.listNilai[j].detail.length; k++) {
                    max[k] = this.list.listNilai[j].detail[k].nilai;
                    min[k] = this.list.listNilai[j].detail[k].nilai;
                }
            }

            for (let index = 1; index < this.list.listNilai.length; index++) {
                for (let i = 0; i < this.list.listNilai[index].detail.length; i++) {
                    if(this.list.listNilai[index].detail[i].nilai >= max[i]){
                        max[i] = this.list.listNilai[index].detail[i].nilai;
                    }else if(this.list.listNilai[index].detail[i].nilai < min[i]){
                        min[i] = this.list.listNilai[index].detail[i].nilai;
                    }
                    
                }
            }                    

            for (let n = 0; n < max.length; n++) {
                this.nilai.nilaiDeviasi[n] = (max[n] - min[n]);
            }

        },

        update() {
            var anyDeviasi = this.nilai.nilaiDeviasi.some(check => check >= 20);
            if(anyDeviasi == false){
                this.penilaian.put(route('penilaian.update', this.penilaian.penilaian_id[0]), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.closeModal();
                    },
                })
            }else if(this.approved == true){
                this.pengumuman = 'Tidak ada yang bisa difinalisasi'
            }else if(anyDeviasi == true){
                this.show = false;
                this.showDeviasi = true;
            }else if(this.blankAnggota == true){
                this.show = false
                this.blankAnggota = true;
                this.approved = false;
            }
        },

        closeModal() {
            this.creatingPenilaian = false;
            this.approved = false;
            this.blankAnggota = false;
            this.show = false;
            this.showDeviasi = false;
            this.form.clearErrors();
            this.penilaian.reset();
            this.nilai.reset();
            this.list.reset();
            this.listAnggota = [];
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