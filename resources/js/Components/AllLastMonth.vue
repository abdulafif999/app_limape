<template>
    
    <div class="shadow-lg rounded-2xl p-4 bg-white dark:bg-gray-800">
        <div class="flex justify-start">            
            <p class="text-md text-black dark:text-white ml-2">
                Progres Penilaian Bulan Lalu
            </p>
        </div>
        <div class="flex flex-col justify-end">
            <p class="text-gray-700 dark:text-gray-100 text-4xl text-left font-bold my-4">
                {{checked_tim}}/{{timList.length}}
            </p>
            <div class="flex items-center text-green-500 text-sm">
                <span>
                    {{parseFloat((checked_tim/timList.length*100).toFixed(2))}}%
                </span>
            </div>
        </div>

        <div class="px-6 mt-4 justify-end">
            <blue-button @click="showTim" >Lihat</blue-button>
        </div>
    </div>

    <jet-dialog-modal :show="show" @close="show = false">
            <template #title>
                Daftar Tim 5P/Unit yang sudah dinilai Bulan Lalu
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
                                        <tr v-for="tim in tim_yang_dinilai" :key="tim.id">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    {{ tim.nama }}
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
        timList:Array,
        penilaians:Array,
        tims:Array,
        penilaianTims:Array,
        currentUser:String,
    },
    data(){
        return {
            checked_tim:0,
            jumlahTim:0,
            tim_yang_dinilai:[],
            show:false,
        }
    },
    mounted(){
        this.getPercentageThisMonth();
    },
    methods:{
        getPercentageThisMonth(){           
            var bulan = new Date() 
            var date = bulan.getMonth()-1;
            var x = 0;
            if(date < 0 ){
                date = 11;
            }
            for (let index = 0; index < this.timList.length; index++) {
                var counter = 0;
                var jumlahAnggota = 0;
                for(var y=0;y<this.penilaianTims.length;y++){
                    for(var z=0;z<this.tims.length;z++){
                        if(this.penilaianTims[y].tim_id == this.tims[z].tim_id && this.penilaianTims[y].tim_unit.id == this.timList[index].id){
                            jumlahAnggota++;
                        }
                    }
                }

                for(var i = 0;i<this.penilaians.length;i++){
                    var periode = new Date(this.penilaians[i].periode);
                    if(periode.getMonth() == date && periode.getFullYear() == bulan.getFullYear() &&  this.timList[index].id == this.penilaians[i].tim_unit_id){
                        counter++;
                    }
                }
                if(counter == jumlahAnggota){
                    this.checked_tim++;
                    this.tim_yang_dinilai[x] = this.timList[index];
                    x++;
                }
            }
            
        },

        showTim(){
            this.show = true;
        }
    }
})
</script>