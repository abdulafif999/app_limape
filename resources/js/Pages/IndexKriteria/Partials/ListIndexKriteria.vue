<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200" >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Periode Index
                                    </th>                                                                                                        
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" :v-on:show="getPeriode()">
                                <tr v-for="periode in periode" :key="periode.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ periode.bulan_awal }} {{periode.tahun_awal}} s/d {{periode.bulan_akhir}} {{periode.tahun_akhir}}
                                        </div>
                                    </td>                                                                 
                                    <td class="px-6 py-4 whitespace-nowrap flex text-right text-sm font-medium">
                                        <blue-button href="#" @click.prevent="showIndexKriteria(periode)" >Show Index</blue-button>
                                        <jet-button href="#" @click.prevent="updateIndexKriteria(periode)" >Edit Periode </jet-button>
                                        <red-button href="#" @click.prevent="ConfirmingIndexKriteriaDeletion(periode)" >Hapus</red-button>
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
        <jet-dialog-modal :show="updatingIndexKriteria" @close="closeModal">
            <template #title>
                Update Index Kriteria
            </template>

            <template #content>
                <div class="mt-4">
                    <div class="flex ml-2">
                                        <label class="text-gray-900">
                                            Periode Awal
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="bulan_awal">
                                                <option value="" disabled selected>Pilih Bulan</option>
                                                <option v-for="(bulan,index) in month" :key="bulan" :value="index">{{bulan}}</option>
                                            </select>     
                                        </label>
                                        <label class="text-gray-900">
                                            Tahun
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="tahun_awal">
                                                <option value="" disabled selected>Pilih Tahun</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>    
                                        </label>          
                                    </div>

                    <jet-input-error :message="form.errors.periode_awal" class="mt-2" />
                </div>  

                <div class="mt-4">
                    <div class="flex ml-2">
                                        <label class="text-gray-900">
                                            Periode Akhir
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="bulan_akhir">
                                                <option value="" disabled selected>Pilih Bulan</option>
                                                <option v-for="(bulan,index) in month" :key="bulan" :value="index">{{bulan}}</option>
                                            </select>     
                                        </label>
                                        <label class="text-gray-900">
                                            Tahun
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="tahun_akhir">
                                                <option value="" disabled selected>Pilih Tahun</option>
                                                <option value="2021">2021</option>
                                                <option value="2022">2022</option>
                                            </select>    
                                        </label>          
                                    </div>

                    <jet-input-error :message="form.errors.periode_akhir" class="mt-2" />
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

        <jet-dialog-modal :show="deletingIndexKriteria" @close="deletingIndexKriteria = false">
            <template #title>
                Delete Index Kriteria
            </template>
            <template #content>
                Yakin ingin menghapus??
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="deletingIndexKriteria = false">
                        Cancel
                    </jet-secondary-button>

                    <red-button class="ml-2" @click="deleteIndexKriteria" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete Index Kriteria
                    </red-button>
                </div>
            </template>
        </jet-dialog-modal>          

        <jet-dialog-modal :show="showingKriteria" @close="closeModal">
            <template #title>
                Daftar Index Kriteria
            </template>

            <template #content>
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
                                Index
                            </th>                                                                                                          
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                                <span class="sr-only">Delete</span>
                            </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="kriteria in show.selectedIndex" :key="kriteria.kriteria">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{kriteria.kriteria}}
                                        </div>
                                    </td>                                                                                              
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{kriteria.sub_kriteria}}
                                        </div>
                                    </td>   
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{kriteria.index}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm flex font-medium">
                                        <jet-button href="#" @click.prevent="updateIndex(kriteria)" >Edit</jet-button>
                                    </td>                                                                                                             
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Close
                </jet-secondary-button>
            </template>

        </jet-dialog-modal>

        <jet-dialog-modal :show="updateSingleIndex" @close="updateSingleIndex = false">
            <template #title>
                Ubah Index
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Kriteria"

                                v-model="form.kriteria"
                                disabled />
                </div> 

                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Sub Kriteria"
                                
                                v-model="form.sub_kriteria"
                                disabled />

                </div> 

                <div class="mt-4">
                    <jet-input type="number" step="0.1" class="mt-1 block w-3/4" placeholder="Index"
                                v-model="form.index"
                                @keyup.enter="updateSingle" />

                    <jet-input-error :message="form.errors.index" class="mt-2" />
                </div>             
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="updateSingleIndex = false">
                        Cancel
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click="updateSingle" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
import BlueButton from '@/Components/BlueButton.vue'
import RedButton from '@/Components/RedButton.vue'
import GreenButton from '@/Components/GreenButton.vue'
import Datepicker from 'vue3-date-time-picker';

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetCheckbox,
        BlueButton,
        RedButton,
        GreenButton,
        Datepicker,
    },

    props: {
        indexKriterias: Array,
        kriterias:Array
    },

    data() {
        return {
            updatingIndexKriteria: false,
            deletingIndexKriteria: false,
            showingKriteria:false,
            updateSingleIndex:false,
            selectedIndexKriteria: {},
            periode:[],
            bulan_awal:'',
            tahun_awanl:'',
            bulan_akhir:'',
            tahun_akhir:'',
            month:[
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ],

            form: this.$inertia.form({
                indexId:'',
                periode_awal:'',
                periode_akhir:'',
                kriteria:'',
                sub_kriteria:'',
                index:'',
            }),

            show:this.$inertia.form({
                selectedIndex: [],
            })
        }
    },

    methods: {
        updateIndexKriteria(kriteria) {
            
            this.updatingIndexKriteria = true;
            this.selectedIndexKriteria = kriteria;
            this.form.periode_awal = kriteria.periode_awal;
            this.form.periode_akhir = kriteria.periode_akhir;
            
            var awal = new Date(this.form.periode_awal);
            var akhir = new Date(this.form.periode_akhir);
            this.bulan_awal = awal.getMonth();
            this.tahun_awal = awal.getFullYear();
            this.bulan_akhir = akhir.getMonth();
            this.tahun_akhir = akhir.getFullYear();

            this.form.indexId = kriteria.id;

        },

        update() {
            var output_awal = '';
            var output_akhir = '';
            if(this.bulan_awal < 9 && this.bulan_awal>=0){
                output_awal = this.tahun_awal + '-' + '0' + (this.bulan_awal+1) + '-' + '01';
            }else if(this.bulan_awal >= 9){
                output_awal = this.tahun_awal + '-' + (this.bulan_awal+1) + '-' + '01';
            }

            if(this.bulan_akhir < 9 && this.bulan_akhir>=0){
                output_akhir = this.tahun_akhir + '-' + '0' + (this.bulan_akhir+1) + '-' + '01';
            }else if(this.bulan_akhir >= 9){
                output_akhir = this.tahun_akhir + '-' + (this.bulan_akhir+1) + '-' + '01';
            }
            this.form.periode_awal = output_awal;
            this.form.periode_akhir = output_akhir;
            this.form.put(route('multiUpdate', this.selectedIndexKriteria.id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.index.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        updateIndex(kriteria){
            this.updateSingleIndex = true;
            this.selectedIndexKriteria = kriteria;
            this.form.kriteria = kriteria.kriteria;
            this.form.sub_kriteria = kriteria.sub_kriteria;
            this.form.index = kriteria.index;
        },
        updateSingle(){
            this.form.put(route('indexKriteria.update', this.selectedIndexKriteria.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.updateSingleIndex = false,
                    this.form.reset();
                    this.showIndexKriteria(this.selectedIndexKriteria); 
                },
                onError: () => this.$refs.index.focus(),
                onFinish: () => this.form.reset(),
            })
        },
        ConfirmingIndexKriteriaDeletion(kriteria) {
            this.deletingIndexKriteria = true;
            this.selectedIndexKriteria = kriteria;

        },

        deleteIndexKriteria() {
            this.form.delete(route('indexKriteria.destroy', this.selectedIndexKriteria.id), {
                preserveScroll: true,
                preserveState:true,
                errorBag: 'delete',
                onSuccess: () => {
                    this.closeModal();
                }
            })            
        },
        showIndexKriteria(kriteria){
            this.show.reset();
            this.showingKriteria = true;
            var j=0;
            for(var i=0;i<=this.indexKriterias.length-1;i++){
                if(kriteria.periode_awal == this.indexKriterias[i].periode_awal && kriteria.periode_akhir == this.indexKriterias[i].periode_akhir){
                    this.show.selectedIndex[j] = this.indexKriterias[i];
                    j++;
                }
            }
        },
        getPeriode(){
            var date = new Date();
            var index = 0;
            var tempArray = this.indexKriterias;
            for(var i = 0; i < this.indexKriterias.length;i++){
                for(var j=i+1;j<this.indexKriterias.length;j++){
                    if(this.indexKriterias[i].periode_awal == this.indexKriterias[j].periode_awal && this.indexKriterias[i].periode_akhir == this.indexKriterias[j].periode_akhir){
                        tempArray[i] = this.indexKriterias[i];
                    }
                }
            };

            for(var i = 0; i < tempArray.length-1;i++){
                if(tempArray[i].periode_awal != tempArray[(i+1)].periode_awal && tempArray[i].periode_akhir != tempArray[(i+1)].periode_akhir){
                    var awal = new Date(tempArray[i].periode_awal);
                    var akhir = new Date(tempArray[i].periode_akhir);
                    this.periode[index] = tempArray[i];
                    this.periode[index].bulan_awal = this.month[awal.getMonth()];
                    this.periode[index].tahun_awal = awal.getFullYear();
                    this.periode[index].bulan_akhir = this.month[akhir.getMonth()];
                    this.periode[index].tahun_akhir = akhir.getFullYear();
                    index++;
                }

            };
            var awal = new Date(tempArray[tempArray.length-1].periode_awal);
            var akhir = new Date(tempArray[tempArray.length-1].periode_akhir); 
            this.periode[index] = tempArray[tempArray.length-1];
            this.periode[index].bulan_awal = this.month[awal.getMonth()];
            this.periode[index].tahun_awal = awal.getFullYear();
            this.periode[index].bulan_akhir = this.month[akhir.getMonth()];
            this.periode[index].tahun_akhir = akhir.getFullYear();
        },

        closeModal() {
            this.updatingIndexKriteria = false,
            this.deletingIndexKriteria = false,
            this.showingKriteria = false,

            this.form.reset()
        },
    },
}
</script>
