<template>
    <app-layout title="Penilaian" :showPenilaian="true">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Penilaian
                <div class="justify-end flex">
                    <create-penilaian :karyawans="karyawans" :tims="tims" :penilaianTims="penilaianTims" :unitDetails="unitDetails" :penilaianDetails="penilaianDetails" :pernum="pernum" :penilaians="penilaians" />
                </div>
            </h2>
        </template>
        
        <div>                
            <div class="bg-green-200 border-green-600 text-green-600 text-center border-l-4 p-4" role="alert" v-if="$page.props.flash.message">
                <p class="font-bold">
                    {{ $page.props.flash.message }}
                </p>
            </div>

        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-penilaian :penilaians="penilaians" :penilaianDetails="penilaianDetails" :tims="tims" 
                :role="role" :pernum="pernum" :timList="timList" :timUnits="timUnits"
                :term="term" :periode="periode" :penilaianTims="penilaianTims" :indexKriterias="indexKriterias" />
            </div>
        </div>

        <div class="py-12" v-if="$page.props.user.role=='user' ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <all-penilaian :penilaians="allPenilaian" :penilaianDetails="penilaianDetails" :tims="tims" 
                :role="role" :pernum="pernum" :timList="timList" :timUnits="timUnits"
                :term="allTerm" :periode="allPeriode" :penilaianTims="penilaianTims" :indexKriterias="indexKriterias" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListPenilaian from './Partials/ListPenilaian.vue'
    import CreatePenilaian from './Partials/CreatePenilaian.vue'
    import AllPenilaian from './Partials/AllPenilaian.vue'
    import Approval from './Partials/Approval.vue'
    
    

    export default defineComponent({
        components: {
            AppLayout,
            ListPenilaian,
            CreatePenilaian,
            AllPenilaian,
            Approval,
            
        },
        props: {
            penilaians: Array,
            karyawans: Array,
            tims: Array,
            penilaianTims:Array,
            unitDetails:Array,
            penilaianDetails:Array,
            pernum:BigInt,
            role:String,
            timList:Array,
            timUnits:Array,
            term:String,
            periode:String,
            allTerm:String,
            allPeriode:String,
            message:String,
            penilaianTims:Array,
            indexKriterias:Array,
            allPenilaian:Array,
            
        },
        method:{
            
        },

    })
</script>