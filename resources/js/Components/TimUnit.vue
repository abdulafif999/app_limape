<template>
    
    <div class="shadow-lg rounded-2xl mx-1 border-black p-4 bg-white ">
        <div class="flex items-center">
            <span class="rounded-xl relative p-4 bg-purple-200">

            </span>
            <p class="text-md text-black dark:text-white ml-2">
                Progres Penilaian Bulan Lalu
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
    </div>

</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
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
            timPenilai:{},
            jumlahTim:0,
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
            var bulan = date.getMonth()-1;
            if(bulan < 0){
                bulan = 11;
            }
            for (let index = 0; index < this.tim_yg_dinilai.length; index++) {
                for(var i = 0;i<this.penilaians.length;i++){
                    var periode = new Date(this.penilaians[i].periode);
                    if(periode.getMonth() == bulan){
                        if(this.penilaians[i].pernum == this.timPenilai.karyawan.pernum){
                            if(this.penilaians[i].tim_unit_id == this.tim_yg_dinilai[index].tim_unit_id){
                                this.checked_tim++;
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
    }
})
</script>
