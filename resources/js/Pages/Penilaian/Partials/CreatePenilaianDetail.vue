<template>
    <app-Layout :showPenilaian="true">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Detail Penilaian
            </h2>
        </template>
        
        <div class="py-12" >
            <div class="mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8" :v-on:show="getDataPenilaian()" >
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8" >
                            <!--List Rank Nilai-->
                            <div class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                                <list-nilai :nilais="nilais" :kriterias="kriterias"></list-nilai>
                            </div>                            
                            <table class="min-w-min divide-y divide-gray-200 mb-5 border-black">
                                <thead class="bg-gray-50 border-black">
                                    <tr>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penilai</th>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Penilaian</th>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tim 5P/Unit yang Dinilai</th>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 border-black border-b-2 border-l-2 border-r-2 border-t">
                                    <tr  class="border-black border-b-2 border-l-2 border-r-2 border-t">
                                        <td class="px-6 py-4">{{this.getData.karyawan.nama}}</td>
                                        <td class="px-6 py-4">{{this.getData.tgl}}</td>
                                        <td class="px-6 py-4">{{this.getData.tim_unit.nama}}</td>
                                        <td class="px-6 py-4">{{this.getData.bulan}}/{{this.getData.tahun}}</td>
                                    </tr>  
                                </tbody>                              
                            </table>            

                            <div class="mt-4 form-group" :v-bind:key="session">

                                <!--Session Penilaian Berdasarkan Kriteria-->
                                    <TabsWrapper>
                                        <Tab title="P1" :isActive="activeTab === 'tab1'" @click="clickTab('tab1', 1)" :class="{ 'bg-red-700 text-white': session == 1 }" />
                                        <Tab title="P2" :isActive="activeTab === 'tab2'" @click="clickTab('tab2', 2)" :class="{ 'bg-blue-700 text-white': session == 2 }" />
                                        <Tab title="P3" :isActive="activeTab === 'tab3'" @click="clickTab('tab3', 3)" :class="{ 'bg-yellow-500 text-white': session == 3 }"/>
                                        <Tab title="P4" :isActive="activeTab === 'tab4'" @click="clickTab('tab4', 4)" :class="{ 'bg-green-600 text-white': session == 4 }"/>
                                        <Tab title="P5" :isActive="activeTab === 'tab5'" @click="clickTab('tab5', 5)" :class="{ 'bg-pink-600 text-white': session == 5 }"/>
                                    </TabsWrapper>

                                    <TabsContent>
                                        <div v-if="activeTab === 'tab1'">
                                            <div class="text-lg bg-red-700 text-white">
                                                <div class="px-8">
                                                    {{header[session-1].kriteria}}
                                                </div>
                                            </div>
                                            <div class="overflow-x-hidden">
                                                <table class="min-w-min divide-y divide-gray-200 mb-5 border-black table table-bordered" style="width:100%">
                                                    <thead class="bg-gray-50 border-black ">
                                                        <tr>
                                                            <th scope="col"
                                                                class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Sub Kriteria
                                                            </th>
                                                            <th scope="col" v-for="item in header[session-1].rank" :key="item"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{item}}
                                                            </th>
                                                            <th scope="col"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200 border-black border-b-2 border-l-2 border-r-2 border-t" v-for="item in header[session-1].sub_kriteria" :key="item.nama">
                                                        <tr class="border-black border-b-2 border-l-2 px-2 border-r-2 border-t">
                                                            <td rowspan="2" class="px-4 py-4 whitespace-nowrap border border-black" style="vertical-align:middle">
                                                                {{item.nama}}
                                                            </td>
                                                            <td class="py-3 text-left text-xs tracking-wider options border-r-2 border-b-2 w-48 border-t-2" style="vertical-align:middle"  v-for="keterangan in item.nilais" :key="keterangan.keterangan">
                                                                <p v-snip:js="3">
                                                                    {{keterangan.keterangan}}
                                                                </p>
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2">
                                                                <div class="flex">
                                                                    <jet-input type="number" max="100" min="0" class="mt-1 block w-auto" placeholder="Nilai"
                                                                    :ref="nilai"
                                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                                    @keyup.enter="create"
                                                                    />
                                                                    <label class="text-sm text-red-600">*</label>
                                                                </div>
                                                                <jet-input-error :message="form.errors['nilai.'+item.kriteriaIndex]" class="mt-2" />
                                                            </td>
                                                        </tr>
                                                        <tr class="border-black border-b-2 px-2 border-l-2 border-r-2 border-t">
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Status
                                                                </div>
                                                                <div>
                                                                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                    ref="status"
                                                                    v-model="form.status[item.kriteriaIndex]"></textarea>
                                                                </div>
                                                                <jet-input-error :message="form.errors['status.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap w-auto border-b-2 border-black" colspan="2">
                                                                    <div>
                                                                        Rekomendasi
                                                                    </div>
                                                                    
                                                                    <div>                                                                                                                       
                                                                        <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                        ref="rekomendasi"
                                                                        v-model="form.rekomendasi[item.kriteriaIndex]"></textarea>
                                                                    </div>
                                                                    <jet-input-error :message="form.errors['rekomendasi.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Foto
                                                                </div>
                                                                <div>
                                                                    <input type="file" class=""
                                                                    :ref="'foto'+item.kriteriaIndex"
                                                                    @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                                    disabled> <label class="border-4"> Fitur ini akan segera hadir</label>

                                                                    <jet-label for="foto" value="Foto" />                                            
                                                                    <div v-show="preview[item.kriteriaIndex]">
                                                                        <span class="block w-20 h-20 rounded-full"
                                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>                              
                                                </table>
                                            </div>                                            
                                        </div>
                                        <div v-if="activeTab == 'tab2'">
                                            <div class="text-lg bg-blue-700 text-white">
                                                <div class="px-8">
                                                    {{header[session-1].kriteria}}
                                                </div>
                                            </div>
                                            <div class="overflow-x-hidden">
                                                <table class="min-w-full divide-y divide-gray-200 mb-5 border-black table table-bordered" style="width:100%">
                                                    <thead class="bg-gray-50 border-black ">
                                                        <tr>
                                                            <th scope="col"
                                                                class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Sub Kriteria
                                                            </th>
                                                            <th scope="col" v-for="item in header[session-1].rank" :key="item"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{item}}
                                                            </th>
                                                            <th scope="col"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200 border-black border-b-2 border-l-2 border-r-2 border-t" v-for="item in header[session-1].sub_kriteria" :key="item.nama">
                                                        <tr class="border-black border-b-2 border-l-2 px-2 border-r-2 border-t">
                                                            <td rowspan="2" class="px-4 py-4 whitespace-nowrap border border-black" style="vertical-align:middle">
                                                                {{item.nama}}
                                                            </td>
                                                            <td class="py-3 text-left text-xs tracking-wider options border-r-2 border-b-2 border-t-2" style="vertical-align:middle"  v-for="keterangan in item.nilais" :key="keterangan.keterangan">
                                                                <p v-snip:js="6">
                                                                    {{keterangan.keterangan}}
                                                                </p>
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2">
                                                                <div class="flex">
                                                                    <jet-input type="number" max="100" min="0" class="mt-1 block w-auto" placeholder="Nilai"
                                                                    :ref="nilai"
                                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                                    @keyup.enter="create"
                                                                    />
                                                                    <label class="text-sm text-red-600">*</label>
                                                                </div>
                                                                <jet-input-error :message="form.errors['nilai.'+item.kriteriaIndex]" class="mt-2" />
                                                            </td>
                                                        </tr>
                                                        <tr class="border-black border-b-2 px-2 border-l-2 border-r-2 border-t">
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Status
                                                                </div>
                                                                <div>
                                                                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                    ref="status"
                                                                    v-model="form.status[item.kriteriaIndex]"></textarea>
                                                                </div>
                                                                <jet-input-error :message="form.errors['status.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap w-auto border-b-2 border-black" colspan="2">
                                                                    <div>
                                                                        Rekomendasi
                                                                    </div>
                                                                    
                                                                    <div>                                                                                                                       
                                                                        <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                        ref="rekomendasi"
                                                                        v-model="form.rekomendasi[item.kriteriaIndex]"></textarea>
                                                                    </div>
                                                                    <jet-input-error :message="form.errors['rekomendasi.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Foto
                                                                </div>
                                                                <div>
                                                                    <input type="file" class=""
                                                                    :ref="'foto'+item.kriteriaIndex"
                                                                    @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                                    disabled> <label class="border-4"> Fitur ini akan hadir segera hadir</label>

                                                                    <jet-label for="foto" value="Foto" />                                            
                                                                    <div v-show="preview[item.kriteriaIndex]">
                                                                        <span class="block w-20 h-20 rounded-full"
                                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>                              
                                                </table>
                                            </div>

                                        </div>
                                        <div v-if="activeTab === 'tab3'">
                                            <div class="text-lg bg-yellow-500 text-white">
                                                <div class="px-8">
                                                    {{header[session-1].kriteria}}
                                                </div>
                                            </div>
                                            <div class="overflow-x-hidden">
                                                <table class="min-w-full divide-y divide-gray-200 mb-5 border-black table table-bordered" style="width:100%">
                                                    <thead class="bg-gray-50 border-black ">
                                                        <tr>
                                                            <th scope="col"
                                                                class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Sub Kriteria
                                                            </th>
                                                            <th scope="col" v-for="item in header[session-1].rank" :key="item"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{item}}
                                                            </th>
                                                            <th scope="col"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200 border-black border-b-2 border-l-2 border-r-2 border-t" v-for="item in header[session-1].sub_kriteria" :key="item.nama">
                                                        <tr class="border-black border-b-2 border-l-2 px-2 border-r-2 border-t">
                                                            <td rowspan="2" class="px-4 py-4 whitespace-nowrap border border-black" style="vertical-align:middle">
                                                                {{item.nama}}
                                                            </td>
                                                            <td class="py-3 text-left text-xs tracking-wider options border-r-2 border-b-2 border-t-2" style="vertical-align:middle"  v-for="keterangan in item.nilais" :key="keterangan.keterangan">
                                                                <p v-snip:js="3">
                                                                    {{keterangan.keterangan}}
                                                                </p>
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2">
                                                                <div class="flex">
                                                                    <jet-input type="number" max="100" min="0" class="mt-1 block w-auto" placeholder="Nilai"
                                                                    :ref="nilai"
                                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                                    @keyup.enter="create"
                                                                    />
                                                                    <label class="text-sm text-red-600">*</label>
                                                                </div>
                                                                <jet-input-error :message="form.errors['nilai.'+item.kriteriaIndex]" class="mt-2" />
                                                            </td>
                                                        </tr>
                                                        <tr class="border-black border-b-2 px-2 border-l-2 border-r-2 border-t">
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Status
                                                                </div>
                                                                <div>
                                                                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                    ref="status"
                                                                    v-model="form.status[item.kriteriaIndex]"></textarea>
                                                                </div>
                                                                <jet-input-error :message="form.errors['status.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap w-auto border-b-2 border-black" colspan="2">
                                                                    <div>
                                                                        Rekomendasi
                                                                    </div>
                                                                    
                                                                    <div>                                                                                                                       
                                                                        <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                        ref="rekomendasi"
                                                                        v-model="form.rekomendasi[item.kriteriaIndex]"></textarea>
                                                                    </div>
                                                                    <jet-input-error :message="form.errors['rekomendasi.'+item.kriteriaIndex]" class="mt-2" />
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Foto
                                                                </div>
                                                                <div>
                                                                    <input type="file" class=""
                                                                    :ref="'foto'+item.kriteriaIndex"
                                                                    @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                                    disabled> <label class="border-4"> Fitur ini akan segera hadir</label>

                                                                    <jet-label for="foto" value="Foto" />                                            
                                                                    <div v-show="preview[item.kriteriaIndex]">
                                                                        <span class="block w-20 h-20 rounded-full"
                                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>                              
                                                </table>
                                            </div>
                                        </div>
                                        <div v-if="activeTab === 'tab4'">
                                            <div class="text-lg bg-green-600 text-white">
                                                <div class="px-8">
                                                    {{header[session-1].kriteria}}
                                                </div>
                                            </div>
                                            <div class="overflow-x-hidden">
                                                <table class="min-w-full divide-y divide-gray-200 mb-5 border-black table table-bordered" style="width:100%">
                                                    <thead class="bg-gray-50 border-black ">
                                                        <tr>
                                                            <th scope="col"
                                                                class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Sub Kriteria
                                                            </th>
                                                            <th scope="col" v-for="item in header[session-1].rank" :key="item"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{item}}
                                                            </th>
                                                            <th scope="col"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200 border-black border-b-2 border-l-2 border-r-2 border-t" v-for="item in header[session-1].sub_kriteria" :key="item.nama">
                                                        <tr class="border-black border-b-2 border-l-2 px-2 border-r-2 border-t">
                                                            <td rowspan="2" class="px-4 py-4 whitespace-nowrap border border-black" style="vertical-align:middle">
                                                                {{item.nama}}
                                                            </td>
                                                            <td class="py-3 text-left text-xs tracking-wider options border-r-2 border-b-2 border-t-2" style="vertical-align:middle"  v-for="keterangan in item.nilais" :key="keterangan.keterangan">
                                                                <p v-snip:js="3">
                                                                    {{keterangan.keterangan}}
                                                                </p>
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2">
                                                                <div class="flex">
                                                                    <jet-input type="number" max="100" min="0" class="mt-1 block w-auto" placeholder="Nilai"
                                                                    :ref="nilai"
                                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                                    @keyup.enter="create"
                                                                    />
                                                                    <label class="text-sm text-red-600">*</label>
                                                                </div>
                                                                <jet-input-error :message="form.errors['nilai.'+item.kriteriaIndex]" class="mt-2" />
                                                            </td>
                                                        </tr>
                                                        <tr class="border-black border-b-2 px-2 border-l-2 border-r-2 border-t">
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Status
                                                                </div>
                                                                <div>
                                                                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                    ref="status"
                                                                    v-model="form.status[item.kriteriaIndex]"></textarea>
                                                                </div>
                                                                <jet-input-error :message="form.errors['status.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap w-auto border-b-2 border-black" colspan="2">
                                                                    <div>
                                                                        Rekomendasi
                                                                    </div>
                                                                    
                                                                    <div>                                                                                                                       
                                                                        <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                        ref="rekomendasi"
                                                                        v-model="form.rekomendasi[item.kriteriaIndex]"></textarea>
                                                                    </div>
                                                                    <jet-input-error :message="form.errors['rekomendasi.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Foto
                                                                </div>
                                                                <div>
                                                                    <input type="file" class=""
                                                                    :ref="'foto'+item.kriteriaIndex"
                                                                    @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                                    disabled> <label class="border-4"> Fitur ini akan hadir segera hadir</label>

                                                                    <jet-label for="foto" value="Foto" />                                            
                                                                    <div v-show="preview[item.kriteriaIndex]">
                                                                        <span class="block w-20 h-20 rounded-full"
                                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>                              
                                                </table>
                                            </div>
                                        </div>
                                        <div v-if="activeTab === 'tab5'">
                                            <div class="text-lg bg-pink-600 text-white">
                                                <div class="px-8">
                                                    {{header[session-1].kriteria}}
                                                </div>
                                            </div>
                                            <div class="overflow-x-hidden">
                                                <table class="min-w-full divide-y divide-gray-200 mb-5 border-black table table-bordered" style="width:100%">
                                                    <thead class="bg-gray-50 border-black ">
                                                        <tr>
                                                            <th scope="col"
                                                                class="py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                                Sub Kriteria
                                                            </th>
                                                            <th scope="col" v-for="item in header[session-1].rank" :key="item"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{item}}
                                                            </th>
                                                            <th scope="col"
                                                                class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="bg-white divide-y divide-gray-200 border-black border-b-2 border-l-2 border-r-2 border-t" v-for="item in header[session-1].sub_kriteria" :key="item.nama">
                                                        <tr class="border-black border-b-2 border-l-2 px-2 border-r-2 border-t">
                                                            <td rowspan="2" class="px-4 py-4 whitespace-nowrap border border-black" style="vertical-align:middle">
                                                                {{item.nama}}
                                                            </td>
                                                            <td class="py-3 text-left text-xs tracking-wider options border-r-2 border-b-2 border-t-2" style="vertical-align:middle"  v-for="keterangan in item.nilais" :key="keterangan.keterangan">
                                                                <p v-snip:js="3">
                                                                    {{keterangan.keterangan}}
                                                                </p>
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2">
                                                                <div class="flex">
                                                                    <jet-input type="number" max="100" min="0" class="mt-1 block w-auto" placeholder="Nilai"
                                                                    :ref="nilai"
                                                                    v-model="form.nilai[item.kriteriaIndex]"
                                                                    @keyup.enter="create"
                                                                    />
                                                                    <label class="text-sm text-red-600">*</label>
                                                                </div>
                                                                <jet-input-error :message="form.errors['nilai.'+item.kriteriaIndex]" class="mt-2" />
                                                            </td>
                                                        </tr>
                                                        <tr class="border-black border-b-2 px-2 border-l-2 border-r-2 border-t">
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Status
                                                                </div>
                                                                <div>
                                                                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                    ref="status"
                                                                    v-model="form.status[item.kriteriaIndex]"></textarea>
                                                                </div>
                                                                <jet-input-error :message="form.errors['status.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap w-auto border-b-2 border-black" colspan="2">
                                                                    <div>
                                                                        Rekomendasi
                                                                    </div>
                                                                    
                                                                    <div>                                                                                                                       
                                                                        <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                                                        ref="rekomendasi"
                                                                        v-model="form.rekomendasi[item.kriteriaIndex]"></textarea>
                                                                    </div>
                                                                    <jet-input-error :message="form.errors['rekomendasi.'+item.kriteriaIndex]" class="mt-2" />
                                                                
                                                            </td>
                                                            <td class="px-2 py-4 whitespace-nowrap border-b-2 border-black" colspan="2">
                                                                <div>
                                                                    Foto
                                                                </div>
                                                                <div>
                                                                    <input type="file" class=""
                                                                    :ref="'foto'+item.kriteriaIndex"
                                                                    @change="updateFotoPreview(item.kriteriaIndex, 'foto'+item.kriteriaIndex)"
                                                                    disabled> <label class="border-4"> Fitur ini akan hadir segera hadir</label>

                                                                    <jet-label for="foto" value="Foto" />                                            
                                                                    <div v-show="preview[item.kriteriaIndex]">
                                                                        <span class="block w-20 h-20 rounded-full"
                                                                                :style="'width: 5rem; height: 5rem; border-radius: 999px; display: block; background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + preview[item.kriteriaIndex] + '\');'">
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>                              
                                                </table>
                                            </div>
                                        </div>           
                                    </TabsContent>
                                    <div>
                                        <p class="flex">
                                            <label class="text-sm text-red-600">*</label> : Wajib Diisi
                                        </p>
                                    </div>                        
                                    <div>
                                        <div>
                                            <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                                {{ form.progress.percentage }}%
                                            </progress>
                                        </div>
                                        <jet-button class="ml-2 mt-4 w-1/4" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                            Create
                                        </jet-button>            
                                    </div>        
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </app-Layout>
</template>
<script>
    import JetButton from '@/Components/GreenButton.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import ListNilai from './ListRankNilai.vue'
    import { Inertia } from '@inertiajs/inertia'
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import {TabsWrapper, TabsContent, Tab} from '@ocrv/vue-tailwind-tabs'



    export default {
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
            JetCheckbox,
            ListNilai,
            TabsWrapper,
            TabsContent,
            Tab,
        },

        props: {
            penilaians: Array,
            kriterias:Array,
            dataPenilaians:Array,
            nilais:Array
        },
        
        mounted(){
                this.getPenilaianId();
                this.clickTab('tab1', 1);
                

                this.form.pernum = this.pernum;
        },

        data() {
            return {
                session:1,
                getData:{},
                header:[],
                activeTab:'tab1',
                preview:[],
            
                form:this.$inertia.form({
                    pernum:'',
                    penilaian_id:'',
                    kriteria:[],
                    nilai:[],
                    foto:[],
                    status:[],
                    rekomendasi:[]
                }),
            }
        },
        methods:{
            getHeader(){
                var getP = ['P1' ,'P2' ,'P3' ,'P4', 'P5'];
                for (var index = 0; index < getP.length; index++){
                    this.header[index] = {};
                    this.header[index].kriteria = getP[index];
                    this.header[index].sub_kriteria = [];
                    this.header[index].kode = [];
                    this.header[index].rank = [];
                    var x = 0;
                    for (let i = 0; i < this.kriterias.length; i++) {
                        if(this.kriterias[i].nama == getP[index]){
                            this.header[index].sub_kriteria[x] = {};
                            this.form.kriteria[i] = this.kriterias[i].id;
                            this.header[index].sub_kriteria[x].nama = this.kriterias[i].sub_kriteria;
                            this.header[index].sub_kriteria[x].kriteriaIndex = i;
                            this.header[index].sub_kriteria[x].nilais = [];
                            var y = 0;

                            for (let j = 0; j < this.nilais.length; j++){
                                if(this.nilais[j].kriteria_id == this.kriterias[i].id){
                                    this.header[index].rank[y] = this.nilais[j].nilai_bawah + '-' + this.nilais[j].nilai_atas;
                                    this.header[index].sub_kriteria[x].nilais[y] = {};
                                    this.header[index].sub_kriteria[x].nilais[y].keterangan =  this.nilais[j].keterangan;
                                    y++;
                                }
                                
                            }
                            x++;
                        }
                    }                                      
                }
            },
            getPenilaianId(){
                this.form.penilaian_id = this.penilaians.penilaian_id;
            },
            getDataPenilaian(){
                for(var index=0;index<=this.dataPenilaians.length-1;index++){
                    if(this.penilaians.penilaian_id == this.dataPenilaians[index].id){
                        this.getData = this.dataPenilaians[index];
                        var date = new Date(this.dataPenilaians[index].periode)
                        this.getData.bulan = date.getMonth()+1;
                        this.getData.tahun = date.getFullYear();
                    }
                }
                this.getHeader();
                
            },
            create() {
                
                var x = this.form.rekomendasi.length;
                var y = this.form.status.length;
                var z = this.form.foto.length;

                if(x < 1){
                    this.form.rekomendasi[this.kriterias.length-1] = '-';
                }else if(x > 1 && this.form.rekomendasi[this.kriterias.length-1] == null){
                    this.form.rekomendasi[this.kriterias.length-1] = '-';
                }
                if(y < 1){
                    this.form.status[this.kriterias.length-1] = '-';
                }else if(y > 1 && this.form.status[this.kriterias.length-1] == null){
                    this.form.status[this.kriterias.length-1] = '-';
                }
                if(z < 1){
                    this.form.foto[this.kriterias.length-1] = '-'
                }else if(z > 1 && this.form.foto[this.kriterias.length-1] == null){
                    this.form.foto[this.kriterias.length-1] = '-';
                }

                
                this.form.post(route('penilaianDetail.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.form.reset();
                    },
                })
            },
            updateFotoPreview(index, name){
                const reader = new FileReader();

                this.form.foto[index] = this.$refs[name].files[0];

                reader.onload = (e) => {
                    this.preview[index] = e.target.result;
                };
                

                reader.readAsDataURL(this.$refs[name].files[0]);
                
            },
            clickTab(name, session){
                this.activeTab = name;
                this.session = session;
            },
            selectNewFoto(index) {
                this.$refs.foto.click();
            },
            // search(){
            //    this.$inertia.replace(this.route('karyawan.index', {term: this.term}))
            // }
        }
    }
</script>
<style scoped>
    .options{
        white-space: pre-wrap;
        word-wrap: break-word;
        max-lines: 8;
        max-width: 250px;
        max-height: 100px;
        overflow: auto;
    }
    .table{
        font-size: 13px;        
        box-sizing: border-box;
        padding: 0;
        -webkit-box-sizing: border-box;
        width: 100%;
        margin: 0 auto;
        clear: both;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table-bordered{
        border: 1px solid #f4f4f4;
        overflow-x: hidden;
        overflow-y: auto;
        font-family: "Poppins", sans-serif;
        font-weight: 400;
        line-height: 1.625;
        color: #666;
        -webkit-font-smoothing: antialiased;
        box-sizing: border-box;
    }
</style>