<template>
    <div>
        <green-button @click="createIndexKriteria">
            Buat Index Kriteria
        </green-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingIndexKriteria" @close="closeModal">
            <template #title>
                Index Kriteria
            </template>

            <template #content>

                <div class="space-x-4 sm:-my-px sm:flex mb-12 sm:self-center align-middle">
                    <div class="flex">
                        <label class="text-gray-900">
                                            Periode Awal :
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="bulan_awal">
                                                <option value="" disabled selected>Pilih Bulan</option>
                                                <option v-for="(bulan,index) in month" :key="bulan" :value="index+1">{{bulan}}</option>
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
                    
                    <div class="flex">
                                        <label class="text-gray-900">
                                            Periode Akhir
                                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                                v-model="bulan_akhir">
                                                <option value="" disabled selected>Pilih Bulan</option>
                                                <option v-for="(bulan,index) in month" :key="bulan" :value="index+1">{{bulan}}</option>
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
                </div> 
                    <div class="mt-4 form-group">
                        <TabsWrapper>
                            <Tab title="P1" :isActive="activeTab === 'tab1'" @click="clickTab('tab1', 1)" :class="{ 'bg-red-700 text-white': session == 1 }" />
                            <Tab title="P2" :isActive="activeTab === 'tab2'" @click="clickTab('tab2', 2)" :class="{ 'bg-blue-700 text-white': session == 2 }" />
                            <Tab title="P3" :isActive="activeTab === 'tab3'" @click="clickTab('tab3', 3)" :class="{ 'bg-yellow-500 text-white': session == 3 }"/>
                            <Tab title="P4" :isActive="activeTab === 'tab4'" @click="clickTab('tab4', 4)" :class="{ 'bg-green-600 text-white': session == 4 }"/>
                            <Tab title="P5" :isActive="activeTab === 'tab5'" @click="clickTab('tab5', 5)" :class="{ 'bg-pink-600 text-white': session == 5 }"/>
                        </TabsWrapper>
                        <TabsContent>
                            <div v-if="activeTab === 'tab1'">
                                <div class="text-red-700">
                                    <label>P1</label>
                                    <div>
                                        <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                                    ref="index"
                                                    v-model="form.singleIndex[0]"
                                                    @keyup.enter="create" />

                                    </div>
                                    
                                    <jet-input-error :message="form.errors.singleIndex" class="mt-2" />
                                </div>

                                <div v-for="item in kriteria1" :key="item.id" class="text-red-700">
                                    <div v-if="item === null"> Tidak ada Kriteria </div>
                                    <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                    <div>
                                        <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                                    ref="index"
                                                    v-model="form.index[item.kriteriaIndex]"
                                                    
                                                    @keyup.enter="update" />

                                        
                                    </div>
                                
                                </div>
                                <div>
                                    <jet-input-error :message="form.errors.index" class="mt-2" />  
                                </div>
                            </div>
                            <div v-if="activeTab === 'tab2'">
                                <div v-on:show="session=2" class="text-indigo-800">
                                    <label>P2</label>
                                    <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                        ref="index"
                                        v-model="form.singleIndex[1]"
                                        @keyup.enter="create"
                                    />
                                    
                                    <jet-input-error :message="form.errors.singleIndex" class="mt-2" />  
                                </div>                        
                                <div v-for="item in kriteria2" :key="item.id" class="text-indigo-800">
                                    <div v-if="item === null"> Tidak ada Kriteria </div>
                                    <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                    <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                        ref="index"
                                        v-model="form.index[item.kriteriaIndex]"
                                        @keyup.enter="create"
                                    />
                                        
                                </div>
                                <div>
                                    <jet-input-error :message="form.errors.index" class="mt-2" />  
                                </div>                        

                            </div>
                            <div v-if="activeTab === 'tab3'">
                                <div v-on:show="session=3" class="text-yellow-600">
                                    <label>P3</label>
                                    <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                        ref="index"
                                        v-model="form.singleIndex[2]"
                                        @keyup.enter="create"
                                    />
                                    
                                    <jet-input-error :message="form.errors.singleIndex" class="mt-2" />  
                                </div>                        
                                <div v-for="item in kriteria3" :key="item.id" class="text-yellow-600">
                                    <div v-if="item === null"> Tidak ada Kriteria </div>
                                    <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                    <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                        ref="index"
                                        v-model="form.index[item.kriteriaIndex]"
                                        @keyup.enter="create"
                                    />
                                    
                                </div>
                                <div>
                                    <jet-input-error :message="form.errors.index" class="mt-2" />  
                                </div>                        

                            </div>
                            <div v-if="activeTab === 'tab4'" >
                                <div v-on:show="session=4" class="text-green-600">
                                    <label>P4</label>
                                    <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                        ref="index"
                                        v-model="form.singleIndex[3]"
                                        @keyup.enter="create"
                                    />
                                    
                                    <jet-input-error :message="form.errors.singleIndex" class="mt-2" />  
                                </div>                         
                                <div v-for="item in kriteria4" :key="item.id" class="text-green-600">
                                    <div v-if="item === null"> Tidak ada Kriteria </div>
                                    <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                    <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                        ref="index"
                                        v-model="form.index[item.kriteriaIndex]"
                                        @keyup.enter="create"
                                    />
                                    
                                </div>
                                <div>
                                    <jet-input-error :message="form.errors.index" class="mt-2" />  
                                </div>                        

                            </div>
                            <div v-if="activeTab === 'tab5'">
                                <div v-on:show="session=5" class="text-pink-600">
                                    <label>P5</label>
                                    <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                        ref="index"
                                        v-model.number="form.singleIndex[4]"
                                        @keyup.enter="create"
                                    />
                                    
                                    <jet-input-error :message="form.errors.singleIndex" class="mt-2" />  
                                </div>                         
                                <div v-for="item in kriteria5" :key="item.id" class="text-pink-600">
                                    <div v-if="item === null"> Tidak ada Kriteria </div>
                                    <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                    <input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Index Kriteria 0-1"
                                        ref="index"
                                        v-model="form.index[item.kriteriaIndex]"
                                        @keyup.enter="create"
                                    />
                                            
                                </div>
                                <div>
                                    <jet-input-error :message="form.errors.index" class="mt-2" />  
                                </div>                                
                            </div>
                        </TabsContent>                
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
import GreenButton from '@/Components/GreenButton.vue'
import {TabsWrapper, TabsContent, Tab} from '@ocrv/vue-tailwind-tabs'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        TabsWrapper,
        TabsContent,
        Tab,
        GreenButton,
    },
    props:{
        kriterias:Array,
    },
    mounted(){
        this.getKriteria1();
        this.getKriteria2();
        this.getKriteria3();
        this.getKriteria4();
        this.getKriteria5();
        this.clickTab('tab1', 1);
    },

    data() {
        return {

            session:1,
            bulan_awal:'',
            tahun_awal:'',
            bulan_akhir:'',
            tahun_akhir:'',
            kriteria1:[],
            kriteria2:[],
            kriteria3:[],
            kriteria4:[],
            kriteria5:[],
            activeTab:'tab1',
            month:[
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ],

            creatingIndexKriteria: false,

            form: this.$inertia.form({
                periode_awal: '',
                periode_akhir: '',
                kriteria: [],
                sub_kriteria: [],
                index: [],
                singleKriteria:[],
                singleIndex:[],
            })
        }
    },

    methods: {
        getKriteria1(){
            this.session = 1;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P1';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P1'){
                    this.kriteria1[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria1[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria1[j].sub_kriteria;
                    this.kriteria1[j].kriteriaIndex = i;
                    
                    j++;
                }
            }
        },
        
        getKriteria2(){
            this.session = 2;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P2';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P2'){
                    this.kriteria2[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria2[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria2[j].sub_kriteria;
                    this.kriteria2[j].kriteriaIndex = i;
                    j++;
                    
                }
            }
        },

        getKriteria3(){
            this.session = 3;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P3';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P3'){
                    this.kriteria3[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria3[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria3[j].sub_kriteria;
                    this.kriteria3[j].kriteriaIndex = i;
                    j++;
                        
                }                
            }            
        },

        getKriteria4(){
            this.session = 4;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P4';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P4'){
                    this.kriteria4[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria4[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria4[j].sub_kriteria;
                    this.kriteria4[j].kriteriaIndex = i;
                    j++;            
                }                
            }                
        },

        getKriteria5(){
            this.session = 5;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P5';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P5'){
                    this.kriteria5[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria5[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria5[j].sub_kriteria;
                    this.kriteria5[j].kriteriaIndex = i;
                    j++;                
                }                
            }            
        }, 

        createIndexKriteria() {
            this.creatingIndexKriteria = true;

        },

        create() {
            var output_awal = '';
            var output_akhir= '';
            if(this.form.singleIndex[4] === ''){
                this.form.singleIndex[4] = '-';
            }
            if(this.bulan_awal < 10 && this.bulan_awal>=1){
                output_awal = this.tahun_awal + '-' + '0' + this.bulan_awal + '-' + '01';
            }else if(this.bulan_awal >= 10){
                output_awal = this.tahun_awal + '-' + this.bulan_awal + '-' + '01';
            }

            if(this.bulan_akhir < 10 && this.bulan_akhir>=1){
                output_akhir = this.tahun_akhir + '-' + '0' + this.bulan_akhir + '-' + '01';
            }else if(this.bulan_akhir >= 10){
                output_akhir = this.tahun_akhir + '-' + this.bulan_akhir + '-' + '01';
            }
            this.form.periode_awal = output_awal;
            this.form.periode_akhir = output_akhir;
            this.form.post(route('indexKriteria.store'), {
                preserveScroll: true,
                onSuccess: () => [
                    this.closeModal(),
                    this.form.reset()
                ],
                onError: () => this.$refs.index.focus(),
            })
        },

        closeModal() {
            this.creatingIndexKriteria = false

            this.form.reset()
        },
        clickTab(name, session){
            this.activeTab = name;
            this.session = session;
        },
    },
}
</script>
