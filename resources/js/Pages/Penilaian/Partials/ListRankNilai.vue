<template>
    <div>
        <blue-button class="rounded-lg hover:shadow-md" @click="showNilai">
            ?
        </blue-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="nilaiKriteriaModal" @close="nilaiKriteriaModal = false">
            <template #title>
                Rank Nilai Kriteria
            </template>

            <template #content>
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <div>
                        <label>Kriteria P1-P5 :</label>
                        <select class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                            v-model="form1.kriteria" :v-on:change="getSubKriteria(form1.kriteria)">
                            <option value="" disabled selected>Pilih Kriteria</option>
                            <option value="P1">P1</option>
                            <option value="P2">P2</option>
                            <option value="P3">P3</option>
                            <option value="P4">P4</option>
                            <option value="P5">P5</option>
                        </select>          
                    </div>
                    <div>
                        <label>Sub Kriteria :</label>
                        <select class="block w-52 py-2 border ml-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                            v-model="form1.sub_kriteria" :v-on:change="getNilaiList(form1.sub_kriteria)">
                            <option value="" disabled selected>Pilih Sub Kriteria</option>
                            <option v-for="sub_kriteria in form.sub_kriteria" :key="sub_kriteria">{{sub_kriteria}}</option>
                        </select>          
                    </div>

                    <div class="mt-4 mb-5" :v-bind:key="form1.sub_kriteria">
                        <label>Keterangan Penilaian : {{this.form.keterangan}}</label>
                    </div>
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>                                 
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Rank Nilai
                                                </th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Keterangan Penilaian
                                                </th>                                
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr v-for="nilai in form.listNilai" :key="nilai.id" :v-bind:key="form1.sub_kriteria">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        {{ nilai.nilai_bawah }} - {{nilai.nilai_atas}}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap display:inline-block">
                                                    <div class="flex items-center relative">
                                                        {{ nilai.keterangan }}
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
                <jet-secondary-button @click="nilaiKriteriaModal = false">
                    Close
                </jet-secondary-button>
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
import BlueButton from '@/Components/BlueButton.vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        BlueButton,
    },

    props:{
        nilais:Array,
        kriterias:Array,
    },

    data() {
        return {
            nilaiKriteriaModal: false,
            form:this.$inertia.form({
                sub_kriteria:[],
                listNilai:[],
                keterangan:'',
            }),
            
            form1:this.$inertia.form({
                kriteria:'',
                sub_kriteria:'',
            })
        }
    },

    mounted () {
    },

    methods: {
        showNilai() {
            this.nilaiKriteriaModal = true;
        },

        getSubKriteria(kriteria){
            this.form.reset();
            var j=0;
            for(var index=0;index<=this.kriterias.length-1;index++){
                if(kriteria == this.kriterias[index].nama){
                    this.form.sub_kriteria[j] = this.kriterias[index].sub_kriteria;
                    j++;
                }
            }
        },

        getNilaiList(sub_kriteria){
            var j=0;
            for(var index=0;index<=this.nilais.length-1;index++){
                if(this.form1.kriteria == this.nilais[index].kriteria.nama && sub_kriteria == this.nilais[index].kriteria.sub_kriteria){
                    this.form.listNilai[j] = this.nilais[index];
                    this.form.keterangan = this.nilais[index].kriteria.keterangan;
                    j++;
                }
            }
        }
    },
}
</script>
