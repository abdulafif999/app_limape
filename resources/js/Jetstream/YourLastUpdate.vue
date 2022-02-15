<template>
    <div>
        <div class="flex flex-col" v-if="form.listNilai.length > 1">
            <div class="px-my-2 overflow-x-auto sm:-mx-2 lg:-mx-2">
                <div class="py-2 align-middle inline-block min-w-full lg:px-2">
                    <div class="overflow-hidden border-b">
                        <table class="min-w-full divide-y divide-gray-200" v-show="form.listNilai">
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
                                    <th scope="col"
                                        class="px-2 py-2 text-left text-xs font-light text-black uppercase tracking-wider">
                                        Status
                                    </th>                          
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="penilaian in form.listNilai.slice(0, 30)" :key="penilaian.nama">
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.nama }}
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
                                    <td class="px-2 py-2 whitespace-nowrap" :class="{ 'text-green-700' :penilaian.approve == 1, 'text-red-600' :penilaian.approve == 0 }">
                                        <div class="flex items-center">
                                            {{ penilaian.status}}
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
<script>

export default{
    props: {
        penilaians:Array,
        currentUser:String,
    },
    mounted(){
        this.getTimPenilai();
    },
    data() {
        return {
            form: this.$inertia.form({
                listNilai: [],
            }),
            
        }
    },
    methods:{
        getTimPenilai(){
            var i=0;
            for(var index=0;index<this.penilaians.length;index++){
                if(this.penilaians[index].pernum == this.currentUser){
                    var periode = new Date(this.penilaians[index].periode);
                    this.form.listNilai[i] = this.penilaians[index]
                    this.form.listNilai[i].nama = this.penilaians[index].tim_unit.nama;
                    this.form.listNilai[i].tgl = this.penilaians[index].tgl;
                    if(this.penilaians[index].approve == true){
                        this.form.listNilai[i].status = 'Sudah difinalisasi';
                    }else{
                        this.form.listNilai[i].status = 'Belum difinalisasi'
                    }
                    
                    i++;
                }
            }
        },
    }
    
    
}
</script>
