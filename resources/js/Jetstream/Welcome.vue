<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                
            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <div class="flex items-center">

                </div>

                <div class="ml-12">
                    <div id="chart">
                        <bar-chart :timList="timList" :penilaianTims="penilaianTims" :penilaianChart="penilaianChart" 
                        :penilaianDetails="penilaianDetails" :tims="tims" :indexKriterias="indexKriterias"
                        :kategoriHasil="kategoriHasil"></bar-chart>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
                    Diagram Ranking Tim 5P/Unit berdasarkan Periode
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        <div id="rankingChart">
                            <ranking-chart :timList="timList" :penilaianTims="penilaianTims" :rankingChart="rankingChart" 
                            :penilaianDetails="penilaianDetails" :tims="tims" :indexKriterias="indexKriterias" 
                            ></ranking-chart>
                        </div>      
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200">
                <div class="flex items-center">                    
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Tim Terakhir yang Dinilai</div>
                </div>

                <div class="ml-12">                  
                    <div class="mt-2 text-sm text-gray-500">
                        <userUpdate :penilaians="penilaians" :currentUser="currentUser" ></userUpdate>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-l">
                <div class="flex items-center">
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Last Updated</div>
                </div>

                <div>
                    <div class="mt-2 text-sm text-gray-500">
                        <last-updated :penilaians="penilaians" :tims="tims" :penilaianDetails="penilaianDetails" :timUnits="timUnits" :currentUser="currentUser"></last-updated>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import BarChart from '@/Jetstream/BarChart.vue'
    import RankingChart from '@/Jetstream/RankingChart.vue'
    import VueApexCharts from "vue3-apexcharts";
    import LastUpdated from '@/Jetstream/LastUpdated.vue'
    import YourLastUpdate from '@/Jetstream/YourLastUpdate.vue'
    import { Container } from 'postcss'
    
    export default defineComponent({
        components: {
            JetApplicationLogo,
            JetButton,
            JetSecondaryButton,
            BarChart,
            RankingChart,
            apexchart:VueApexCharts,
            LastUpdated,
            userUpdate:YourLastUpdate,
        },
        props:{
            penilaianDetails:Array,
            penilaians:Array,
            tims:Array,
            timUnits:Array,
            penilaianChart:Object,
            rankingChart:Object,
            timList:Array,
            penilaianTims:Array,
            indexKriterias:Array,
            kategoriHasil:Array,
            currentUser:String,
        },
    })
</script>

