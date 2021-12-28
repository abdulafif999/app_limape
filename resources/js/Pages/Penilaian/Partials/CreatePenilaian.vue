<template>
    <div>
        <green-button @click="createPenilaian">
            Tambah Penilaian
        </green-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingPenilaian" @close="closeModal">
            <template #title>
                Create Penilaian
            </template>
        
            <template #content>
                <div class="sm:-my-px sm:ml-1 sm:flex bg-gray mt-12 mb-14">
                            <div v-if="$page.props.user.role==='admin'">
                                <div>
                                    <label class="text-gray-700">Tanggal Penilaian
                                        <jet-input type="date" class="block w-52 py-2 ml-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" placeholder="Tanggal Penilaian"
                                                    ref="tgl"
                                                    v-model="form.tgl"
                                                    @keyup.enter="create" />

                                        <jet-input-error :message="form.errors.tgl" class="mt-2" />
                                    </label>
                                    <div class="flex">
                                        <label class="text-gray-900">
                                            Periode
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="bulan" @change="setPeriode()">
                                                <option value="" disabled selected>Pilih Bulan</option>
                                                <option v-for="bulan in periode_bulan" :key="bulan.index" :value="bulan.index+1">{{bulan.nama}}</option>
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
                                    <jet-input-error :message="form.errors.periode" class="mt-2" />

                                </div>
                                    <label class="text-gray-900">
                                        Penilai
                                        <select class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                            required v-model="form.pernum" v-on:change="getPenilaianTim(form.pernum)">
                                            <option value="" disabled selected>Pilih Penilai</option>
                                            <option v-for="karyawan in tims" :key="karyawan.id" :value="karyawan.karyawan.pernum">{{karyawan.karyawan.nama}} - {{karyawan.tim.nama}}</option>
                                        </select>
                                    
                                        <jet-input-error :message="form.errors.pernum" class="mt-2" />     
                                    </label>
                                    <label class="text-gray-700">
                                        Tim yang Dinilai
                                        <select class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                            v-model="form.tim_unit_id">
                                            <option value="" disabled selected>Pilih Tim 5P/Unit</option>
                                            <option v-for="tim in form1.timList" :key="tim.tim_unit_id" :value="tim.tim_unit_id">{{tim.tim_unit.nama}}</option>
                                        </select>
                                        <jet-input-error :message="form.errors.tim_unit_id" class="mt-2" />  
                                    </label>
                            </div>
                            <div v-else-if="$page.props.user.role === 'user'" :v-on:show="setPenilaianData()">
                                <div :v-on:show="getPenilaianTim($page.props.user.pernum)" >
                                    <div>
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
                                                <option v-for="bulan in periode_bulan" :key="bulan.index" :value="(bulan.index)+1">{{bulan.nama}}</option>
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
                                    <jet-input-error :message="form.errors.periode" class="mt-2" />

                                </div>
                                    <label class="text-gray-700" >
                                        Tim yang Dinilai
                                        <select class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                            v-model="form.tim_unit_id">
                                            <option value="" disabled selected>Pilih Tim 5P/Unit</option>
                                            <option v-for="tim in form1.timList" :key="tim.tim_unit_id" :value="tim.tim_unit_id">{{tim.tim_unit.nama}}</option>
                                        </select>
                                        <jet-input-error :message="form.errors.tim_unit_id" class="mt-2" />  
                                    </label>                                    
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
            openNilai:false, 
            listTim:[],
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
                tgl: new Date(),
                pernum: '',
                tim_unit_id: '',
                periode:''
            }), 
            form1: this.$inertia.form({
                timList: [],
            }),             
                      
        }
    },
    props:{
        tims:Array,
        penilaians:Array,
        penilaianTims:Array,
        penilaianDetails:Array,
        pernum:String,
    },

    methods: {
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
            if(this.bulan < 10 && this.bulan>=1){
                var output = this.tahun + '-' + '0' + this.bulan + '-' + '01';
            }else if(this.bulan >= 10){
                var output = this.tahun + '-' + this.bulan + '-' + '01';
            }
            this.form.periode = output;
        },

        create() {
            
            this.form.post(route('penilaian.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.form.closeModal();
                    this.form.reset();
                },
            })
        },

        getPeriode(){
            var date = new Date();
            var batas_awal = date.getMonth()-2;
            var batas_akhir = date.getMonth();
            var counter = 0;
            var x=0;
            
            for(batas_awal = date.getMonth()-2;batas_awal<=batas_akhir;batas_awal++){
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

        closeModal() {
            this.creatingPenilaian = false
            this.form.clearErrors()
            this.form.reset()

        }, 
    }
}
</script>
