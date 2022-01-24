<template>
    <app-Layout :showPenilaian="true">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Detail Penilaian
            </h2>
        </template>
        
        <div class="py-12" >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8" :v-on:show="getDataPenilaian()" >
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8" >
                            <!--List Rank Nilai-->
                            <div class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                                <list-nilai :nilais="nilais" :kriterias="kriterias"></list-nilai>
                            </div>                            
                            <table class="min-w-full divide-y divide-gray-200 mb-5 border-black">
                                <thead class="bg-gray-50 border-black">
                                    <tr>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penilai</th>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Penilaian</th>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tim 5P/Unit yang Dinilai</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 border-black border-b-2 border-l-2 border-r-2 border-t">
                                    <tr  class="border-black border-b-2 border-l-2 border-r-2 border-t">
                                        <td class="px-6 py-4 whitespace-nowrap">{{this.getData.karyawan.nama}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{this.getData.tgl}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{this.getData.tim_unit.nama}}</td>
                                    </tr>  
                                </tbody>                              
                            </table>            

                            <div class="mt-4 form-group" :v-bind:key="session">

                                <!--Session Penilaian Berdasarkan Kriteria-->
                                    <TabsWrapper>
                                        <Tab title="P1" :isActive="activeTab === 'tab1'" @click="clickTab('tab1', 1)" :class="{ 'bg-red-700 text-white': session == 1 }" />
                                        <Tab title="P2" :isActive="activeTab === 'tab2'" @click="clickTab('tab2', 2)" :class="{ 'bg-blue-700 text-white': session == 2 }" />
                                        <Tab title="P3" :isActive="activeTab === 'tab3'" @click="clickTab('tab3', 3)" :class="{ 'bg-yellow-500 text-white': session == 3 }"/>
                                        <Tab title="P4" :isActive="activeTab === 'tab4'" @click="clickTab('tab4', 4)" :class="{ 'bg-green-600 text-white': session == 4 }"/>
                                        <Tab title="P5" :isActive="activeTab === 'tab5'" @click="clickTab('tab5', 5)" :class="{ 'bg-pink-600 text-white': session == 5 }"/>
                                    </TabsWrapper>

                                    <TabsContent>
                                        <div v-if="activeTab === 'tab1'">
                                            <div v-for="item in kriteria1" :key="item.id" class="text-red-600 mb-4">
                                            <div v-if="item === null"> Tidak ada Kriteria </div>
                                            <label class="bg-red border-black">{{item.nama}} - {{item.sub_kriteria}}</label>
                                                <input type="number" max="100" min="0" class="mt-1 block w-1/12" placeholder="Nilai"
                                                ref="nilai"
                                                v-model="form.nilai[item.kriteriaIndex]"
                                                @keyup.enter="create"
                                            />

                                            <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                            <div>
                                                <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                    ref="status"
                                                    v-model="form.status[item.kriteriaIndex]"
                                                    @keyup.enter="create" />

                                                <jet-input-error :message="form.errors.status" class="mt-2" />
                                            </div>
                                            <div>
                                                <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                    ref="rekomendasi"
                                                    v-model="form.rekomendasi[item.kriteriaIndex]"
                                                    @keyup.enter="create" />

                                                <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                            </div>
                                            <div>
                                                <input type="file" class=""
                                                            :ref="'foto'+item.kriteriaIndex"
                                                            @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                            disabled> <label class="border-4"> Fitur ini akan hadir segera </label>

                                                <jet-label for="foto" value="Foto" />                                            

                                                <jet-input-error :message="form.errors.foto" class="mt-2" />                                

                                                <div v-show="preview[item.kriteriaIndex]">
                                                    <span class="block w-20 h-20 rounded-full"
                                                            :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        </div>
                                        <div v-if="activeTab === 'tab2'">
                                            <div v-for="item in kriteria2" :key="item.id" class="text-blue-700  mb-4">
                                                <div v-if="item === null"> Tidak ada Kriteria</div>
                                                <label class="bg-white border-black">{{item.nama}} - {{item.sub_kriteria}}</label>
                                                <input max="100" min="0" type="number" class="mt-1 block w-1/12" placeholder="Nilai"
                                                    ref="nilai"
                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                    @keyup.enter="create" />

                                                <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                                <div>
                                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                        ref="status"
                                                        v-model="form.status[item.kriteriaIndex]"
                                                        @keyup.enter="create" />

                                                    <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                                </div>
                                                <div>
                                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                        ref="rekomendasi"
                                                        v-model="form.rekomendasi[item.kriteriaIndex]"
                                                        @keyup.enter="create" />

                                                    <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                                </div>
                                                <div>
                                                    <input type="file" class=""
                                                            :ref="'foto'+item.kriteriaIndex"
                                                            @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                            disabled> <label class="border-4"> Fitur ini akan hadir segera </label>

                                                    <jet-label for="foto" value="Foto" />                                            

                                                    <jet-input-error :message="form.errors.foto" class="mt-2" />                                

                                                    <div v-show="preview[item.kriteriaIndex]">
                                                        <span class="block w-20 h-20 rounded-full"
                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div v-if="activeTab === 'tab3'">
                                            <div v-for="item in kriteria3" :key="item.id" class="text-yellow-700 mb-4">
                                                <div v-if="item === null"> Tidak ada Kriteria   </div>
                                                <label class="bg-white border-black">{{item.nama}} - {{item.sub_kriteria}}</label>
                                                <input max="100" min="0" type="number" class="mt-1 block w-1/12" placeholder="Nilai"
                                                    ref="nilai"
                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                    @keyup.enter="create" />

                                                <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                                <div>
                                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                        ref="status"
                                                        v-model="form.status[item.kriteriaIndex]"
                                                        @keyup.enter="create" />

                                                    <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                                </div>
                                                <div>
                                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                        ref="rekomendasi"
                                                        v-model="form.rekomendasi[item.kriteriaIndex]"
                                                        @keyup.enter="create" />

                                                    <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                                </div>
                                                <div>
                                                    <input type="file" class=""
                                                            :ref="'foto'+item.kriteriaIndex"
                                                            @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                            disabled> <label class="border-4"> Fitur ini akan hadir segera </label>

                                                    <jet-label for="foto" value="Foto" />                                            

                                                    <jet-input-error :message="form.errors.foto" class="mt-2" />                                

                                                    <div v-show="preview[item.kriteriaIndex]">
                                                        <span class="block w-20 h-20 rounded-full"
                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                        </span>
                                                    </div>                            
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="activeTab === 'tab4'">
                                            <div v-for="item in kriteria4" :key="item.id" class="text-green-600 mb-4">
                                                <div v-if="item === null"> Tidak ada Kriteria   </div>
                                                <label class="bg-white border-black">{{item.nama}} - {{item.sub_kriteria}}</label>
                                                <input max="100" min="0" type="number" class="mt-1 block w-1/12" placeholder="Nilai"
                                                    ref="nilai"
                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                    @keyup.enter="create" />

                                                <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                                <div>
                                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                        ref="status"
                                                        v-model="form.status[item.kriteriaIndex]"
                                                        @keyup.enter="create" />

                                                    <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                                </div>
                                                <div>
                                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                        ref="rekomendasi"
                                                        v-model="form.rekomendasi[item.kriteriaIndex]"
                                                        @keyup.enter="create" />

                                                    <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                                </div>
                                                <div >
                                                    <input type="file" class=""
                                                            :ref="'foto'+item.kriteriaIndex"
                                                            @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                            disabled> <label class="border-4"> Fitur ini akan hadir segera </label>

                                                    <jet-label for="foto" value="Foto" />                                            

                                                    <jet-input-error :message="form.errors.foto" class="mt-2" />                                

                                                    <div v-show="preview[item.kriteriaIndex]">
                                                        <span class="block w-20 h-20 rounded-full"
                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                        </span>
                                                    </div>                             
                                                </div>
                                            </div>

                                        </div>
                                        <div v-if="activeTab === 'tab5'">
                                            <div v-for="item in kriteria5" :key="item.id" class="text-pink-600 mb-4">
                                                <div v-if="item === null"> Tidak ada Kriteria   </div>
                                                <label class="bg-white border-black">{{item.nama}} - {{item.sub_kriteria}}</label>
                                                <input max="100" min="0" type="number" class="mt-1 block w-1/12" placeholder="Nilai"
                                                    ref="nilai"
                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                    @keyup.enter="create" />

                                                <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                                <div>
                                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                        ref="status"
                                                        v-model="form.status[item.kriteriaIndex]"
                                                        @keyup.enter="create" />

                                                    <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                                </div>
                                                <div>
                                                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                        ref="rekomendasi"
                                                        v-model="form.rekomendasi[item.kriteriaIndex]"
                                                        @keyup.enter="create" />

                                                    <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                                </div>
                                                <div>
                                                    <input type="file" class=""
                                                            :ref="'foto'+item.kriteriaIndex"
                                                            @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                            disabled> <label class="border-4"> Fitur ini akan hadir segera </label>

                                                    <jet-label for="foto" value="Foto" />                                            

                                                    <jet-input-error :message="form.errors.foto" class="mt-2" />                                

                                                    <div v-show="preview[item.kriteriaIndex]">
                                                        <span class="block w-20 h-20 rounded-full"
                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                        </span>
                                                    </div>                             
                                                </div>
                                            </div>
                                        </div>           
                                    </TabsContent>                                <div>
                                    <jet-button class="ml-2 mt-4 w-1/4" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Create
                                    </jet-button>            
                                </div>        
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </app-Layout>
</template>
<script>
    import JetButton from '@/Jetstream/Button.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import ListNilai from './ListRankNilai.vue'
    import { Inertia } from '@inertiajs/inertia'
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import {TabsWrapper, TabsContent, Tab} from '@ocrv/vue-tailwind-tabs'



    export default {
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
            JetCheckbox,
            ListNilai,
            TabsWrapper,
            TabsContent,
            Tab,
        },

        props: {
            penilaians: Array,
            kriterias:Array,
            dataPenilaians:Array,
            nilais:Array
        },
        
        mounted(){
                this.getKriteria1(),
                this.getKriteria2(),
                this.getKriteria3();
                this.getKriteria4();
                this.getKriteria5();
                this.getPenilaianId();
                this.clickTab('tab1', 1)
                this.form.pernum = this.pernum;
        },

        data() {
            return {
                session:1,
                kriteria1:[],
                kriteria2:[],
                kriteria3:[],
                kriteria4:[],
                kriteria5:[],
                getData:{},
                activeTab:'tab1',
                preview:[],
            
                form:this.$inertia.form({
                    pernum:'',
                    penilaian_id:'',
                    kriteria:[],
                    nilai:[],
                    foto:[],
                    status:[],
                    rekomendasi:[]
                }),
            }
        },
        methods:{
            getKriteria1(){
                this.session = 1;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P1'){
                        this.kriteria1[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria1[j].id;
                        this.kriteria1[j].kriteriaIndex = i;
                        j++;
                        
                    }
                }
                

            },
            getKriteria2(){
                this.session = 2;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P2'){
                        this.kriteria2[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria2[j].id;
                        this.kriteria2[j].kriteriaIndex = i;
                        j++;
                        
                    }
                }
            },
            getKriteria3(){
                this.session = 3;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P3'){
                        this.kriteria3[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria3[j].id;
                        this.kriteria3[j].kriteriaIndex = i;
                        j++;
                        
                    }                
                }            
            },                
            getKriteria4(){
                this.session = 4;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P4'){
                        this.kriteria4[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria4[j].id;
                        this.kriteria4[j].kriteriaIndex = i;
                        j++;
                        
                    }                
                }            
                
            },
            getKriteria5(){
                this.session = 5;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P5'){
                        this.kriteria5[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria5[j].id;
                        this.kriteria5[j].kriteriaIndex = i;
                        j++;
                        
                    }                
                }            
            },
            getPenilaianId(){
                this.form.penilaian_id = this.penilaians.penilaian_id;
            },
            getDataPenilaian(){
                for(var index=0;index<=this.dataPenilaians.length-1;index++){
                    if(this.penilaians.penilaian_id == this.dataPenilaians[index].id){
                        this.getData = this.dataPenilaians[index];
                    }
                }
            },
            create() {
                
                var x = this.form.rekomendasi.length;
                var y = this.form.status.length;
                var z = this.form.foto.length;

                if(x < 1){
                    this.form.rekomendasi[this.kriterias.length-1] = '-';
                }else if(x > 1 && this.form.rekomendasi[this.kriterias.length-1] == null){
                    this.form.rekomendasi[this.kriterias.length-1] = '-';
                }
                if(y < 1){
                    this.form.status[this.kriterias.length-1] = '-';
                }else if(y > 1 && this.form.status[this.kriterias.length-1] == null){
                    this.form.status[this.kriterias.length-1] = '-';
                }
                if(z < 1){
                    this.form.foto[this.kriterias.length-1] = '-'
                }else if(z > 1 && this.form.foto[this.kriterias.length-1] == null){
                    this.form.foto[this.kriterias.length-1] = '-';
                }

                
                this.form.post(route('penilaianDetail.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.form.reset();
                    },
                })
            },
            updateFotoPreview(index, name){
                const reader = new FileReader();

                this.form.foto[index] = this.$refs[name].files[0];

                reader.onload = (e) => {
                    this.preview[index] = e.target.result;
                };
                

                reader.readAsDataURL(this.$refs[name].files[0]);
                
            },
            clickTab(name, session){
                this.activeTab = name;
                this.session = session;
            },
            selectNewFoto(index) {
                this.$refs.foto.click();
            },
            // search(){
            //    this.$inertia.replace(this.route('karyawan.index', {term: this.term}))
            // }
        }
    }
</script>
