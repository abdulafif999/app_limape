<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <tr class="mb-3 border-b-2">                                
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Pencarian
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>                          
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-3 ml-9 text-left justify-start text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        
                                    </th>
                            
                                    <th scope="col"
                                        class="text-left ml-6 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cari Tim
                                        <select  class="block w-52 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                            @change="searchTerm()" v-model="term" id="search" type="text" >
                                                                                    
                                            <option value="">Pilih Tim 5P/Unit</option>
                                            <option value="semua">Semua</option>
                                            <option v-for="tim in timUnits" :key="tim.id" :value="tim.id">{{tim.nama}}</option>
                                        </select>
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs justify-end font-medium text-gray-500 uppercase tracking-wider">
                                        Periode
                                            <label class="flex">
                                                
                                                <select class="block py-2 border border-gray-300 bg-white rounded-md overflow-y:scroll shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                    v-model="bulan" @change="setPeriode()">
                                                    <option value="" selected disabled>Pilih Bulan</option>
                                                    <option value="" selected>Semua</option>
                                                    <option v-for="bulan in month" :key="bulan.index" :value="bulan.index+1">{{bulan.nama}}</option>
                                                </select>     
                                                <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                    v-model="tahun" @change="setPeriode()">
                                                    <option value="" disabled selected>Pilih Tahun</option>
                                                    <option value="2021">2021</option>
                                                    <option value="2022">2022</option>
                                                </select>    
                                            </label>
                                    </th>
                                    <th scope="colgroup"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            
                                    </th>
                                    <th></th>
                                                                      
                                </tr>
                        </table>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr class="border-t-2">
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
                                        Nama Penilai
                                    </th>                                   
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tim 5P/Unit yg Dinilai
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Penilaian
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Periode
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Detail Nilai</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="(penilaian, index) in data.dataPenilaian.slice().reverse()" :key="penilaian.id">
                                    <td class="px-6 py-4 whitespace-nowrap border-r-2">
                                        <div class="flex items-center">
                                            {{ index+1 }}
                                        </div>
                                    </td>                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.nama_tim }}
                                        </div>
                                    </td> 
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.karyawan.nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.tim_unit.nama }}
                                        </div>
                                    </td>                                                                        
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.tgl }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.bulan }}/{{penilaian.tahun}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right flex text-sm font-medium">
                                        <span><blue-button href="#" @click.prevent="openNilai(penilaian)">Show Nilai</blue-button></span>
                                    </td>                                    
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
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
                                    <div class="flex items-center">
                                        {{ penilaian.status }}
                                    </div>
                                </td>                                             
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ penilaian.rekomendasi }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        {{ penilaian.foto }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span><jet-button v-if="$page.props.user.pernum == penilaian.penilaian.pernum && $page.props.user.role == 'user'" href="#" @click.prevent="editConfirmation(penilaian)">Edit Nilai</jet-button></span>
                                        <span><jet-button v-if="$page.props.user.role == 'admin'" href="#" @click.prevent="editConfirmation(penilaian)">Edit Nilai</jet-button></span>
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
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nilai_atas" class="mt-2" />                    
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Keterangan"
                                ref="keterangan"
                                v-model="edit.status"
                                rows="4"
                                cols="50">
                    </textarea>

                    <jet-input-error :message="form.errors.nilai_bawah" class="mt-2" />                    
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Rekomendasi"
                                ref="rekomendasi"
                                v-model="edit.rekomendasi"
                                rows="4"
                                cols="50">
                    </textarea>
                    <input type="file"
                        ref="foto"
                        @change="updateFotoPreview()"
                        disabled > <label class="text-red-500">Fitur ini akan hadir segera</label>

                    <jet-label for="foto" value="Foto" />                                            
                    <jet-input-error :message="form.errors.foto" class="mt-2" />                                

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

                    <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import {TabsWrapper, TabsContent, Tab} from '@ocrv/vue-tailwind-tabs'


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
        Tab

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
    },
    mounted(){
        this.getData();
        
        
    },

    data() {
        return {
            detailNilai: false,
            editModal:false,
            selectedPenilaian:{},
            editObject:{},
            nilaiTotal:0,
            maxWidth:'2md',
            preview:'',
            bulan:'',
            tahun:2021,

            
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
        },
        getData(){
            var x = 0;
            if(this.role == 'admin'){
                this.data.dataPenilaian = this.penilaians
                for(var k=0;k<this.penilaians.length;k++){
                    var period = new Date(this.penilaians[k].periode)
                    this.data.dataPenilaian[k].bulan = period.getMonth()+1;
                    this.data.dataPenilaian[k].tahun = period.getFullYear();
                }
            }
            else if(this.role == 'user'){
                for(var i=0;i<this.tims.length;i++){
                    if(this.tims[i].karyawan.pernum == this.pernum){
                        for(var index=0;index<this.penilaians.length;index++){
                            for(var j=0;j<this.tims.length;j++){
                                if(this.tims[j].tim_id == this.tims[i].tim_id){
                                    if(this.tims[j].karyawan.pernum == this.penilaians[index].pernum){
                                            var period = new Date(this.penilaians[index].periode)
                                            this.data.dataPenilaian[x] = this.penilaians[index];
                                            this.data.dataPenilaian[x].bulan = period.getMonth()+1;
                                            this.data.dataPenilaian[x].tahun = period.getFullYear();
                                            this.data.dataPenilaian[x].nama_tim = this.tims[j].tim.nama
                                            x++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            this.getTimPenilai();
            
        },
        

        getTimPenilai(){
            for(var index=0;index<=this.penilaians.length-1;index++){
                for(var j=0;j<=this.tims.length-1;j++){
                    if(this.penilaians[index].pernum == this.tims[j].karyawan.pernum){
                        var period = new Date(this.penilaians[index].periode)
                        this.penilaians[index].nama_tim = this.tims[j].tim.nama;
                        this.penilaians[index].bulan = period.getMonth()+1;
                        this.penilaians[index].tahun = period.getFullYear();
                    }
                }
            }
            for(var i =0;i<this.month.length;i++){
                this.month[i].index = i;
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
            if(this.bulan < 10 && this.bulan>=1){
                var output = this.tahun + '-' + '0' + this.bulan + '-' + '01';
            }else if(this.bulan >= 10){
                var output = this.tahun + '-' + this.bulan + '-' + '01';
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
            if(this.term == 'semua'){
                this.$inertia.get(this.route('penilaian.index', {term: '', periode:''}, {preserveState:true, replace:true}));
                this.getData();
            }else{
                this.$inertia.get(this.route('penilaian.index', {term: this.term, periode:this.form.periode}, {preserveState:true, replace:true}));
                this.getData();
            }
            
        },
        searchPeriode(){
            if(this.bulan == 'semua'){
                this.$inertia.get(this.route('penilaian.index', {term:this.term, periode: ''}, {preserveState:true}));
                this.getData();
            }else{
                this.$inertia.get(this.route('penilaian.index', {term:this.term, periode: this.form.periode}, {preserveState:true}));
                this.getData();
            }
        }
    },
}
</script>




