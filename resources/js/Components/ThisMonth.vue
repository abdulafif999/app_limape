<template>
    
    <div class="shadow-lg rounded-2xl p-4 bg-white dark:bg-gray-800">
        <div class="flex items-center">
            <span class="rounded-xl relative p-4 bg-purple-200">

            </span>
            <p class="text-md text-black dark:text-white ml-2">
                Progres Penilaian Bulan ini
            </p>
        </div>
        <div class="flex flex-col justify-end">
            <p class="text-gray-700 dark:text-gray-100 text-4xl text-left font-bold my-4">
                {{checked_tim}}/{{tim_yg_dinilai.length}}
            </p>
            <div class="flex items-center text-green-500 text-sm">
                <span>
                    {{parseFloat((checked_tim/tim_yg_dinilai.length*100).toFixed(2))}}%
                </span>
            </div>
        </div>

        <div class="px-6 mt-4">
            <blue-button @click="showTim" >Lihat</blue-button>
        </div>
    </div>

    <jet-dialog-modal :show="show" @close="show = false">
            <template #title>
                Daftar Tim 5P/Unit yang sudah dinilai Bulan ini
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
                                                Nama Tim
                                            </th>                                                           
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr v-for="tim in listTim" :key="tim.id">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ tim.tim_unit.nama }}
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
                <jet-secondary-button @click="show = false">
                    Close
                </jet-secondary-button>
            </template>
        </jet-dialog-modal>

</template>

<script>
import { defineComponent } from 'vue'
import BlueButton from '@/Components/BlueButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default defineComponent({
    components:{
        BlueButton,
        JetDialogModal,
        JetSecondaryButton,
    },
    props:{
        timList:String,
        penilaians:Array,
        tims:Array,
        penilaianTims:Array,
        currentUser:String,
    },
    data(){
        return {
            checked_tim:0,
            tim_yg_dinilai:[{}],
            listTim:[],
            timPenilai:{},
            jumlahTim:0,
            show:false,
        }
    },
    mounted(){
        this.getPercentageThisMonth();
    },
    methods:{
        getPercentageThisMonth(){
            this.getJumlahTim();
            this.getTimPenilai();
            var date = new Date()
            var x = 0;
            for (let index = 0; index < this.tim_yg_dinilai.length; index++) {
                for(var i = 0;i<this.penilaians.length;i++){
                    var periode = new Date(this.penilaians[i].periode);
                    if(periode.getMonth() == date.getMonth()){
                        if(this.penilaians[i].pernum == this.timPenilai.karyawan.pernum){
                            if(this.penilaians[i].tim_unit_id == this.tim_yg_dinilai[index].tim_unit_id){
                                this.checked_tim++;
                                this.listTim[x] = this.tim_yg_dinilai[index]
                                x++;
                            }
                            

                        }
                    }
                }
            }
            
        },
        getJumlahTim(){
            var x=0;
            for (let i = 0; i < this.penilaianTims.length; i++) {
                for (let j = 0; j < this.tims.length; j++) {
                    if(this.tims[j].karyawan.pernum == this.currentUser){
                        if(this.penilaianTims[i].tim_id == this.tims[j].tim_id){
                            this.tim_yg_dinilai[x] = this.penilaianTims[i];
                            x++;
                        }
                    }
                    
                }
                
            }
        },
        getTimPenilai(){
            for (let i = 0; i < this.tims.length; i++) {
                if(this.tims[i].karyawan.pernum == this.currentUser){
                    this.timPenilai = this.tims[i]
                }
                
            }
        },

        showTim(){
            this.show = true;
        }
    }
})
</script>
