<template>
    <div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-white">
                                <tr>                                
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-medium text-black uppercase tracking-wider">
                                        Tim 5P/Unit yg Dinilai
                                    </th>                                    
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-light text-black uppercase tracking-wider">
                                        Tanggal Penilaian
                                    </th>
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-light text-black uppercase tracking-wider">
                                        Periode
                                    </th>
                                    <th scope="col" class="relative px-2 py-2 text-left text-xs font-light text-black uppercase tracking-wider">
                                        Hasil Penilaian
                                    </th> 

                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 scroll">
                                <tr v-for="penilaian in penilaians.slice(0, 20)" :key="penilaian.id">
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.tim_unit.nama }}
                                        </div>
                                    </td>                                                                        
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.tgl }}
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{new Date(penilaian.periode).getMonth()+1}}/{{new Date(penilaian.periode).getFullYear()}}
                                        </div>
                                    </td>                                
                                    <td class="px-2 py-2 flex whitespace-nowrap">
                                        <div class="flex items-center">
                                            <blue-button @click="showPenilaian(penilaian)" class="h-auto">Lihat</blue-button>
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
        <jet-dialog-modal :show="showModal" @close="closeModal" :max-width="maxWidth">
            <template #title>
                Status dan Rekomendasi untuk {{this.selectedPenilaian.tim_unit.nama}}
            </template>

            <template #content>
                <div class="mt-4">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200 table table-bordered" style="width:100%">
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
                                                <td class="px-6 py-4 whitespace-nowrap options">
                                                    <div class="py-3 text-left text-xs tracking-wider options" style="vertical-align:middle">
                                                        {{ penilaian.status }}
                                                    </div>
                                                </td>                                             
                                                <td class="px-6 py-4 whitespace-nowrap options">
                                                    <div class="py-3 text-left text-xs tracking-wider options" style="vertical-align:middle">
                                                        {{ penilaian.rekomendasi }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
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
                <jet-secondary-button @click="closeModal">
                    Close
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>
    </div>
</template>
<script>
import BlueButton from '../Components/BlueButton.vue';
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default{
    components: {
        BlueButton,
        JetDialogModal,
        JetSecondaryButton,
    },
    props: {
        penilaians:Array,
        tims:Array,
        penilaianDetails:Array,
        timUnits:Array,
        currentUser:String,
    },
    data() {
        return {
           showModal:false,
           selectedPenilaian:{},
           form: this.$inertia.form({
                listNilai: [],
                periode:'',
                
            }),
            date:new Date(this.penilaians.periode),
            tim:{},
            maxWidth:'3xl'
        }
    },
    mounted(){
        this.getTimUnit();
    },
    methods:{
        getTimUnit(){
            for(var i=0;i<this.timUnits.length;i++){
                if(this.timUnits[i].pernum == this.currentUser){
                    this.tim = this.timUnits[i];
                }
            }
        },
        showPenilaian(penilaian){
            this.showModal = true;
            this.selectedPenilaian = penilaian;
            this.addNilai(penilaian);
            
        },

        addNilai(penilaian){
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
        closeModal(){
            this.showModal = false;
            this.form.reset();
        }
    }
    
    
}
</script>

<style scoped>
    .scroll{
        list-style: none;
        padding-left: 8px;
        max-height: 300px;
        overflow-y: scroll;
        border: 1px solid lightgray;
    }
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
</style>
