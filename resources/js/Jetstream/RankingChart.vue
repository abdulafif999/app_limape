<template>
    <div class="bg-white mb-5">
        <div class="mt-3 flex items-center text-sm font-semibold">
            <div class="mr-4 flex">
                        <label class="text-gray-900">
                            Periode
                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                v-model="bulan" @change="setPeriode()">
                                <option value="" disabled selected>Pilih Bulan</option>
                                <option v-for="(bulan,index) in month" :key="bulan" :value="index">{{bulan}}</option>
                            </select>     
                        </label>
                        <label class="text-gray-900">
                            Tahun
                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                v-model="tahun" @change="setPeriode()">
                                <option value="" disabled selected>Pilih Tahun</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                            </select>    
                        </label>
                        <label class="">
                            .
                            <jet-button class="ml-4 h-10 py-2" @click="getRanking()">
                                Lihat
                            </jet-button>
                        </label>
            </div>
    </div>
    <div class="mt-3 flex items-center mb-5 text-sm font-semibold">
            <div class="options border-transparent" v-bind:ref="'karyawan'+index">
                <ul v-show="list.daftarTim">
                    <li v-for="(tim,index) in list.daftarTim" :key="tim.id" class="hover:bg-blue-800" @click="fillData(tim, index)">
                        {{index+1}}. {{tim.nama}} - {{tim.nilai_final}}
                    </li>
                </ul>
            </div>           
    </div>
  </div>

  <div v-show="selectedTim" id="rankingChart">
    <apexcharts
      ref="chart"
      :width="rankingChart.width"
      height="300"
      :type="rankingChart.type"
      :options="rankingChart.options"
      :series="rankingChart.series">
    </apexcharts>
  </div>

  <div>
      <div v-show="daftar">
        <div class="row">
          <div class="bg-white column" v-for="daftar in daftar" :key="daftar.nama_tim">
              <div class="">
                  <ul class="overflow-y: none">
                        <li>
                            {{daftar.nama_tim}}
                        </li>
                    <div v-for="(nilai, index) in daftar.nilai" :key="nilai.nilai">
                        P{{index+1}} = {{nilai}}
                    </div>
                </ul>
              </div>
          </div>
                </div>
      </div>

  </div>


</template>

<script>
import JetButton from '@/Jetstream/Button.vue'
import VueApexCharts from "vue3-apexcharts"
import JetInput from '@/Jetstream/Input.vue'


export default {
  name: "RankingChart",
  components: {
    JetButton,
    JetInput,
    apexcharts:VueApexCharts,
  },
  props:{
    tims:Array,
    timList:Array,
    penilaianTims:Array,
    rankingChart:Object,
    penilaianDetails:Array,
    indexKriterias:Array,


  },
  data(){
      return {
        
        month:['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],

        form:this.$inertia.form({
            rank:'',
            timRank:{},
            periode:'',
        }),
        value:this.$inertia.form({
            categoriesTemp:[],
            seriesTemp:[]
        }),
        list:this.$inertia.form({
            daftarTim:[{}],
            listTim:[]
        }),
        bulan:'',
        tahun:'',
        daftar:[],
        selectedTim:{},

      }
  },

  methods:{
      getRanking(){
        this.list.reset();
        var bulan_periode = this.bulan;
        var tahun_periode = this.tahun;          

        for(var h=0;h < this.timList.length;h++){

            var nilai_final = 0;
            var total = [];
            var kategori= [];
            this.list.daftarTim[h] = this.timList[h];
            this.list.daftarTim[h].tim = [];
            var i=0;
            
            
            
            var jumlahAnggota = 0;
            
            for(var y=0;y<this.penilaianTims.length;y++){
                for(var z=0;z<this.tims.length;z++){
                    if(this.penilaianTims[y].tim_id == this.tims[z].tim_id && this.penilaianTims[y].tim_unit.nama == this.timList[h].nama){
                        jumlahAnggota++;
                    }
                }
            };
            
            for(var index=0;index < this.penilaianTims.length;index++){
                if(this.penilaianTims[index].tim_unit.nama == this.timList[h].nama){
                    this.list.daftarTim[h].tim[i] = {
                        nama_tim:'',
                        nilai:[],
                    };
                    this.list.daftarTim[h].tim[i].nama_tim = this.penilaianTims[index].tim.nama;
                    kategori[i] = this.penilaianTims[index].tim.nama;
                    this.list.daftarTim[h].tim[i].nilai = [];
                    var w = 0;
                    var x = 0;
                    var kriteria_array = [];
                    var total_array = [];
                    for(var j=0;j < this.penilaianDetails.length;j++){                       
                        var sub_total = 0;
                        var index_kriteria = '';
                        kriteria_array[x] = {};
                        if(this.penilaianDetails[j].penilaian.tim_unit_id == this.penilaianTims[index].tim_unit_id){
                        for(var k=0;k<this.tims.length;k++){
                            if(this.penilaianDetails[j].penilaian.pernum == this.tims[k].karyawan.pernum && this.tims[k].tim_id == this.penilaianTims[index].tim_id){
                            for(var l=0;l < this.indexKriterias.length;l++){
                                var periode_awal = new Date(this.indexKriterias[l].periode_awal);
                                var periode_akhir = new Date(this.indexKriterias[l].periode_akhir);
                                var periode_penilaian = new Date(this.penilaianDetails[j].penilaian.periode);
                                if(periode_penilaian.getMonth() >= periode_awal.getMonth() && periode_penilaian.getFullYear() >= periode_awal.getFullYear() 
                                && periode_penilaian.getMonth() <= periode_akhir.getMonth() && periode_penilaian.getFullYear() <= periode_akhir.getFullYear()
                                ){      
                                    if(this.indexKriterias[l].kriteria == this.penilaianDetails[j].kriteria.nama && this.indexKriterias[l].sub_kriteria == this.penilaianDetails[j].kriteria.sub_kriteria){
                                        sub_total = sub_total + this.penilaianDetails[j].nilai
                                        index_kriteria = this.indexKriterias[l].index;
                                    }
                                }               
                            }
                            
                            }                    
                        }    
                        kriteria_array[x].sub_nilai = (sub_total/jumlahAnggota) * index_kriteria;
                        kriteria_array[x].kriteria = this.penilaianDetails[j].kriteria.nama;
                        kriteria_array[x].sub_kriteria = this.penilaianDetails[j].kriteria.sub_kriteria;
                        kriteria_array[x].tgl = this.penilaianDetails[j].penilaian.periode;
                        x++;
                        }
                    }
                    
                    for(var a = 0;a < this.indexKriterias.length; a++){
                        if(this.indexKriterias[a].sub_kriteria == ''){

                            
                            total_array[w] = 0;
                            var periode_awal = new Date(this.indexKriterias[a].periode_awal);
                            var periode_akhir = new Date(this.indexKriterias[a].periode_akhir);
                            if(bulan_periode >= periode_awal.getMonth() && tahun_periode >= periode_awal.getFullYear()
                            && bulan_periode <= periode_akhir.getMonth() && tahun_periode <= periode_akhir.getFullYear()
                            ){                   
                                for(var b = 0;b < kriteria_array.length;b++){
                                    var penilaian = new Date(kriteria_array[b].tgl);
                                    if(this.indexKriterias[a].kriteria == kriteria_array[b].kriteria){
                                        if(penilaian.getMonth() >= periode_awal.getMonth() && penilaian.getFullYear() >= periode_awal.getMonth() && penilaian.getMonth() <= periode_akhir.getMonth() && penilaian.getFullYear() <= periode_akhir.getFullYear()){
                                            total_array[w] = total_array[w] + kriteria_array[b].sub_nilai;
                                        }
                                    }
                                }
                                this.list.daftarTim[h].tim[i].nilai[w] = parseFloat((total_array[w]).toFixed(2));
                                total_array[w] = total_array[w] * this.indexKriterias[a].index
                                w++; 
                            }
                            
                            
                        }
                    }
                    total[i] = 0;
                    for(var c=0;c < total_array.length;c++){
                        total[i] = parseFloat((total[i] + total_array[c]).toFixed(2));
                        
                    }
                    
                    i++;
                }
            }
            for(var d=0; d < total.length;d++){
                nilai_final = nilai_final + total[d];
            }
            this.list.daftarTim[h].nilai_final = parseFloat((nilai_final/i).toFixed(2));
            this.list.daftarTim[h].kategori = kategori;
            this.list.daftarTim[h].series = total
        }
        this.addRanking();
      },
      addRanking(){
        var tempObject = {};
            for(var i = 0; i < this.list.daftarTim.length;i++){
                for(var j=i+1;j<this.list.daftarTim.length;j++){
                    if(this.list.daftarTim[j].nilai_final >= this.list.daftarTim[i].nilai_final){
                        tempObject = this.list.daftarTim[j];
                        this.list.daftarTim[j] = this.list.daftarTim[i];
                        this.list.daftarTim[i] = tempObject;
                    }
                }
            }    
      },
      fillData(tim, index){
        this.selectedTim = tim;
        this.rankingChart.options = {
            xaxis:{
                categories:tim.kategori,
            },
            chart:{ 
                toolbar:true,
                animations:{
                    enabled:true,
                },
                subtitle:{
                    text:tim.rank
                },
                

            },
            markers:{
                size:2,
                click:this.getKriteria(tim.tim),
            },
            legend:{
                show:true,
                showForSingleSeries: true,
                showForNullSeries: true,
                showForZeroSeries: true,
                toggleDataSeries: true,
                position:'bottom',
                onItemHover: {
                    highlightDataSeries: true,
                },
            },
            colors: ['#E91E63', '#66DA26', '#2E93fA', '#546E7A',  '#FF9800'],
        };
        this.rankingChart.series[0].data = tim.series
        this.rankingChart.series[0].name = tim.nama
        this.rankingChart.series[0].tim = tim.tim
        this.renderChart(this.rankingChart.options, this.rankingChart.series);
      },
      renderChart(options, series){
        var chartQuarter = new ApexCharts(this.$refs.chart, this.rankingChart.options);
        chartQuarter.destroy();
        chartQuarter.updateOptions(options);
        chartQuarter.updateSeries(series);
        chartQuarter.render();          
      },

      setPeriode(){
            if(this.bulan < 10 && this.bulan>=1){
                var output = this.tahun + '-' + '0' + this.bulan + '-' + '01';
            }else if(this.bulan >= 10){
                var output = this.tahun + '-' + this.bulan + '-' + '01';
            }
            this.form.periode = output;          
      },
      getKriteria(kriteria){
          this.daftar = kriteria;
      },
    
  }
}
</script>

<style scoped>
    .options{
        width: 75%;
    }        
    ul{
        list-style: none;
        text-align: left;
        padding-left: 8px;
        max-height: 200px;
        overflow-y: scroll;
        overflow-x: hidden;
        border: 1px solid lightgray;
    }
    li{
        width: 100%;
        border-bottom: 1px solid lightgray;
        padding: 10px;
        background-color: #f1f1f1;
        cursor: pointer;
    }
    .row {
        display: flex;
    }

    .column {
    flex: 50%;
    }
</style>