<template>
    <div class="bg-white mb-5">
        <div class="mt-3 flex items-center text-sm font-semibold">
            <div class="mr-4 flex">
                        <label class="text-gray-900">
                            Tahun
                            <select class="block py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                                v-model="tahun">
                                <option value="" disabled selected>Pilih Tahun</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                            </select>    
                        </label>
            </div>

            
    </div>
    <div class="mt-3 flex items-start mb-5 text-sm font-semibold">
        <label class="">
            Nama Tim
        </label>
        <div class="items-start mx-auto my-auto">
            
                <jet-input v-model="inputTim" @input="filterTim()" type="text" class="h-8" placeholder="Search Here.." />
                <div v-if="dataTim" class="options border-transparent" v-bind:ref="'tim'">
                    <ul>
                        <li v-for="(tim,index) in dataTim" :key="tim.id" class="hover:bg-blue-800" @click="getRanking(tim, index)">
                            {{index+1}}. {{tim.nama}}
                        </li>
                    </ul>
                </div>
            
        </div>    
    </div>
  </div>

  <div v-if="selectedTim" id="rankingChart">
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
        <div class="row" :v-bind="daftar">
          <div class="bg-white column" v-for="daftar in daftar.tim" :key="daftar.nama_tim">
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
    apexcharts:VueApexCharts
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
        tahun:2022,
        daftar:[],
        selectedTim:{},
        dataList:[],
        dataTim:this.timList,
        inputTim:'',

      }
  },

  methods:{
      getRanking(tim, index){
        this.list.reset();
        var tahun_periode = this.tahun;
        var jumlahAnggota = 0;

        for(var y=0;y<this.penilaianTims.length;y++){
            for(var z=0;z<this.tims.length;z++){
                if(this.penilaianTims[y].tim_id == this.tims[z].tim_id && this.penilaianTims[y].tim_unit.id == tim.id){
                    jumlahAnggota++;
                }
            }
        }

        for(var bulan_periode = 0; bulan_periode <12; bulan_periode++){

            this.list.daftarTim[bulan_periode] = tim;
            this.list.daftarTim[bulan_periode].tim = [];
            var nilai_final = 0;
            var total = [];
            var kategori= [];
            var i=0;

            for(var z=0;z < this.penilaianTims.length;z++){
                    if(this.penilaianTims[z].tim_unit.id == tim.id){
                        this.list.daftarTim[bulan_periode].tim[i] = {
                            nama_tim:'',
                            nilai:[],
                        };
                        this.list.daftarTim[bulan_periode].tim[i].nama_tim = this.penilaianTims[index].tim.nama;
                        this.list.daftarTim[bulan_periode].tim[i].nilai = [];
                        kategori[i] = this.penilaianTims[z].tim.nama;
                        var w = 0;
                        var x = 0;
                        var kriteria_array = [];
                        var total_array = [];
                        for(var j=0;j < this.penilaianDetails.length;j++){                       
                            var sub_total = 0;
                            var index_kriteria = '';
                            kriteria_array[x] = {};
                            if(this.penilaianDetails[j].penilaian.tim_unit_id == this.penilaianTims[z].tim_unit_id){
                            for(var k=0;k<this.tims.length;k++){
                                if(this.penilaianDetails[j].penilaian.pernum == this.tims[k].karyawan.pernum && this.tims[k].tim_id == this.penilaianTims[z].tim_id){
                                for(var l=0;l < this.indexKriterias.length;l++){
                                    var periode_awal = new Date(this.indexKriterias[l].periode_awal);
                                    var periode_akhir = new Date(this.indexKriterias[l].periode_akhir);
                                    var periode_penilaian = new Date(this.penilaianDetails[j].penilaian.periode);
                                    if(periode_penilaian.getMonth() >= periode_awal.getMonth() && periode_penilaian.getFullYear() >= periode_awal.getFullYear() 
                                    && periode_penilaian.getMonth() <= periode_akhir.getMonth() && periode_penilaian.getFullYear() <= periode_akhir.getFullYear()
                                    && bulan_periode == periode_penilaian.getMonth() && tahun_periode == periode_penilaian.getFullYear()
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
                                    this.list.daftarTim[bulan_periode].tim[i].nilai[w] = parseFloat((total_array[w]).toFixed(2));
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
                this.list.daftarTim[bulan_periode].nilai_final = parseFloat((nilai_final/i).toFixed(2));
                this.list.daftarTim[bulan_periode].kategori = kategori;
                this.list.daftarTim[bulan_periode].series = total
                this.dataList[bulan_periode] = parseFloat((nilai_final/i).toFixed(2));
        }
        tim.series = this.dataList;
        this.fillData(tim);
      },
      fillData(tim, index){
        this.selectedTim = tim;
        this.rankingChart.options = {
            chart:{
                toolbar:{
                    show:true,
                },
                animations:{
                    enabled:true,
                },
                zoom: {
                    enabled: true,
                    type: 'x',  
                    autoScaleYaxis: false,  
                    zoomedArea: {
                        fill: {
                        color: '#90CAF9',
                        opacity: 0.4
                        },
                        stroke: {
                        color: '#0D47A1',
                        opacity: 0.4,
                        width: 1
                        }
                    }
                },
                events: {
                    markerClick: function(event, chartContext, { seriesIndex, dataPointIndex, config}) {
                        this.getKriteria(seriesIndex);
                    }
                }   
                

            },
            xaxis: {
                categories: this.month,
            },
            markers:{
                size:2,
                onClick:function(e){
                    this.daftar = tim.tim
                }
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
                onItemClick:{
                    toggleDataSeries:true,
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
        history = new History();
        history.replaceState(chartQuarter);

        var obj;
        obj = JSON.parse(JSON.stringify(obj));
        parent.postMessage(obj, this.route('dashboard'));
      },

      setPeriode(){
            if(this.bulan < 10 && this.bulan>=1){
                var output = this.tahun + '-' + '0' + this.bulan + '-' + '01';
            }else if(this.bulan >= 10){
                var output = this.tahun + '-' + this.bulan + '-' + '01';
            }
            this.form.periode = output;          
      },
      getKriteria(index, tim){
          this.daftar = this.list.daftarTim[index];
      },
      filterTim(){
        const query = this.inputTim.toLowerCase();
        if(this.inputTim === ''){
            return this.dataTim;
        }
        this.dataTim = this.timList.filter((nama) => {
            return Object.values(nama).some((word) => String(word).toLowerCase().includes(query));
        })
      }
    
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