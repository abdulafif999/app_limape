<template>
    <app-layout title="Dashboard" :showPenilaian="showPenilaian">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg items-center">
                    <div class="bg-white mt-4 items-center justify-center mx-auto rounded-lg">
                        <p class="text-gray-800 text-xl text-center font-medium mb-4 py-4 ">
                            Selamat Datang di Aplikasi Penilaian 5P
                        </p>

                        <p class="text-gray-400 text-center px-2">
                            Aplikasi ini digunakan untuk memudahkan penilai dari Tim/Unit 5p melakukan penilaian terhadap kinerja 5P yang ada di lingkungan Semen Padang
                        </p>

                    </div>
                    
                    <div class="items-center object-center justify-items-center justify-center">
                        <gambar-dashboard></gambar-dashboard>
                    </div>
                    

                </div>
            </div>
        </div>

        <div class="py-4" v-if="$page.props.user.role=='user' && showPenilaian">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg items-center">
                        <div class="self-center  flex justify-center">
                            <this-month :timList="timPenilai" :penilaians="penilaians" :tims="tims" :penilaianTims="penilaianTims" :currentUser="currentUser" class="px-3"></this-month>

                            <last-month :timList="timPenilai" :penilaians="penilaians" :tims="tims" :penilaianTims="penilaianTims" :currentUser="currentUser" class="px-3"></last-month>
                        </div>
                </div>
            </div>
        </div>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xl sm:rounded-lg items-center">
                        <div class="self-center  flex justify-center">
                            <all-this-month :timList="timList" :penilaians="penilaians" :tims="tims" :penilaianTims="penilaianTims"  class="px-3"></all-this-month>

                            <all-last-month :timList="timList" :penilaians="penilaians" :tims="tims" :penilaianTims="penilaianTims"  class="px-3"></all-last-month>
                        </div>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <welcome :penilaianDetails="penilaianDetails" :penilaians="penilaians" 
                    :tims="tims" :timUnits="timUnits" :penilaianChart="penilaianChart" 
                    :timList="timList" :penilaianTims="penilaianTims" 
                    :indexKriterias="indexKriterias" :rankingChart="rankingChart"
                    :kategoriHasil="kategoriHasil" :currentUser="currentUser" :approvedPenilaians="approvedPenilaians"
                     />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import GambarDashboard from '@/Components/GambarDashboard.vue'
    import ThisMonth from '@/Components/ThisMonth.vue'
    import LastMonth from '@/Components/LastMonth.vue'
    import AllThisMonth from '@/Components/AllThisMonth.vue'
    import AllLastMonth from '@/Components/AllLastMonth.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
            GambarDashboard,
            ThisMonth,
            LastMonth,
            AllThisMonth,
            AllLastMonth

        },
        data(){
            return{
                showPenilaian:false,
            }
        },

        props:{
            penilaianDetails:Array,
            penilaians:Array,
            tims:Array,
            timUnits:Array,
            penilaianChart:Object,
            timPenilai:Array,
            rankingChart:Object,
            timList:Array,
            penilaianTims:Array,
            indexKriterias:Array,
            kategoriHasil:Array,
            currentUser:String,
            role:String,
            approvedPenilaians:Array,
        },
        mounted(){
            this.getKetua();
        },
        methods:{
            getKetua(){
            if(this.role == 'admin'){
                this.showPenilaian = true;
            }
            else{
                this.showPenilaian = this.tims.some(tim => tim.karyawan.pernum == this.currentUser);
            }
            },
        }
    })
</script>
