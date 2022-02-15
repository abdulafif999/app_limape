<template>
  <div class="mb-4 flex items-center bg-white">
      <div class="flex">
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
                            <jet-button class="ml-4 h-10 py-2" @click="fillData()">
                                Lihat
                            </jet-button>
                        </label>
      </div>
  </div>

  <div id="chart">
    <apexcharts
      ref="chart"
      :width="penilaianChart.width"
      :height="tinggi"
      :type="penilaianChart.type"
      :options="penilaianChart.options"
      :series="penilaianChart.series"
      :key="penilaianChart.options">
    </apexcharts>
  </div>
</template>

<script>
import JetButton from '@/Jetstream/Button.vue'
import VueApexCharts from "vue3-apexcharts"
import JetInput from '@/Jetstream/Input.vue'

export default {
  name: "Chart",
  components: {
    JetButton,
    JetInput,
    apexcharts:VueApexCharts,
  },
  props:{
    tims:Array,
    timList:Array,
    penilaianTims:Array,
    penilaianChart:Object,
    penilaianDetails:Array,
    indexKriterias:Array,
    kategoriHasil:Array,

  },
  data() {
    return {
        month:['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
        tinggi:300,

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
            listTim:[],
            series:[{}],
        }),
        bulan:'',
        tahun:2022,
        daftar:[],
        selectedTim:{},
    }     

  },

  methods: {
    getRandomInt () {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 5
    },
    getRanking(){
        this.list.reset();
        var bulan_periode = this.bulan;
        var tahun_periode = this.tahun;
        this.list.series[0].data = []  

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
                          var periode_penilaian = new Date(this.penilaianDetails[j].penilaian.periode);    
                          for(var k=0;k<this.tims.length;k++){
                            if(this.penilaianDetails[j].penilaian.pernum == this.tims[k].karyawan.pernum && this.tims[k].tim_id == this.penilaianTims[index].tim_id){
                            for(var l=0;l < this.indexKriterias.length;l++){
                                var periode_awal = new Date(this.indexKriterias[l].periode_awal);
                                var periode_akhir = new Date(this.indexKriterias[l].periode_akhir);
                                if(periode_penilaian.getMonth() >= periode_awal.getMonth() && periode_penilaian.getFullYear() >= periode_awal.getFullYear() 
                                && periode_penilaian.getMonth() <= periode_akhir.getMonth() && periode_penilaian.getFullYear() <= periode_akhir.getFullYear()
                                && bulan_periode == periode_penilaian.getMonth() && periode_penilaian.getFullYear() == tahun_periode
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
            this.list.series[0].data[h] = this.list.daftarTim[h].nilai_final
            
        }
        this.addRanking();
      },
      addRanking(){
        this.list.series[0].data = []
        var tempObject = '';
            for(var i = 0; i < this.list.daftarTim.length;i++){
                for(var j=i+1;j<this.list.daftarTim.length;j++){
                    if(this.list.daftarTim[j].nilai_final >= this.list.daftarTim[i].nilai_final){
                        tempObject = this.list.daftarTim[j];
                        this.list.daftarTim[j] = this.list.daftarTim[i];
                        this.list.daftarTim[i] = tempObject;
                    }
                }
              this.list.listTim[i] = this.list.daftarTim[i].nama;
              this.list.series[0].data[i] = this.list.daftarTim[i].nilai_final;
              if(this.list.series[0].data[i] == ''){
                this.list.series[0].data[i] = null;
              }
            }
            

      },
    fillData(){
      this.getRanking();
      this.tinggi = 800;
      this.penilaianChart.options = {
        chart: {
              type: 'bar',
              height: 800,
              toolbar:{
                    show:true,
                    offsetX: 0,
                    offsetY: 0,
                    tools: {
                      download: true,
                      selection: true,
                      zoom: true,
                      zoomin: true,
                      zoomout: true,
                      pan: true,
                      reset: true,
                      customIcons: []
                    },
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
            },
            fill: {
              colors: [function({ value, seriesIndex, w }) {
                if(value > 0 && value <= 20) {
                  // hitam
                    return '#000000'
                } else if (value > 20 && value <= 40) {
                  // merah
                    return '#FF0000'
                }else if (value > 40 && value <= 60) {
                  // kuning
                    return '#FFD700'
                }else if (value > 60 && value <= 80) {
                  // biru
                    return '#0000FF'
                }else {
                  // hijau
                    return '#2ca01e'
                }
              }],
            },
            plotOptions: {
              bar: {
                borderRadius: 4,
                horizontal: true,
              }
            },
            dataLabels: {
              enabled: false
            },
            xaxis: {
              categories: this.list.listTim
            },
            colors: ['#33b2df', '#546E7A', '#d4526e', '#13d8aa', '#A5978B', '#2b908f', '#f9a3a4', '#90ee7e',
              '#f48024', '#69d2e7'
            ],
            markers:{
                size:2,
            },
            legend:{
                show:true,
                showForNullSeries: true,
                showForZeroSeries: true,
                toggleDataSeries: true,
                position:'bottom',
                onItemHover: {
                    highlightDataSeries: true,
                },
            },
            
      }
      this.penilaianChart.series[0].data = this.list.series[0].data
      this.renderChart(this.penilaianChart.options, this.penilaianChart.series);

    },
    renderChart(options, series){
      var chartQuarter = new ApexCharts(this.$refs.chart, this.penilaianChart.options);
      chartQuarter.destroy();
      chartQuarter.updateOptions(options);
      chartQuarter.updateSeries(series);
      chartQuarter.render();          
      chartQuarter.zoomX(1, 10);
    },

    getPeringkat(){
      if(this.form.kriteria == 'total'){
        var total = 0;
        for(var j=0;j<this.value.total_final.length;j++){
          total = total + this.value.total_final[j];
        }
        total = total/j;
        for(var i=0;i<this.kategoriHasil.length;i++){
          if(total >= this.kategoriHasil[i].nilai_bawah && total <= this.kategoriHasil[i].nilai_atas){
            this.value.peringkat = this.kategoriHasil[i].nama;
          }
        }
      }
      else {
        this.value.peringkat = '';
      }
    },

    setPeriode(){
            if(this.bulan < 9 && this.bulan>=0){
                var output = this.tahun + '-' + '0' + this.bulan+1 + '-' + '01';
            }else if(this.bulan >= 9){
                var output = this.tahun + '-' + this.bulan+1 + '-' + '01';
            }
            this.form.periode = output;          
    },
  }
}
</script>
