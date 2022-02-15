<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <div>
                            <label for="search">Search</label>
                            <jet-input id="search" type="text" v-model="term" @keyup="search" class="ml-2 px-2 py-2 text-sm rounded border"></jet-input>
                            <label>By Name</label>
                        </div>    
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NIK
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NIP
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>                                                                        
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Lahir
                                    </th>   
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Kelamin
                                    </th>  
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Band
                                    </th>     
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Direktorat
                                    </th>            
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Departemen
                                    </th>         
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit
                                    </th>         
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                         Bidang
                                    </th>    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kode Area
                                    </th>   
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>                                                                                                                                                                                                                                                                            
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="karyawan in displayedPosts" :key="karyawan.nip">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.pernum }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.nip }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.nama }}
                                        </div>
                                    </td>                                                                        
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.tgl_lahir }}
                                        </div>
                                    </td>                   
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.jk }}
                                        </div>
                                    </td>                  
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.jabatan }}
                                        </div>
                                    </td>                     
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.dir }}
                                        </div>
                                    </td>                        
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.dep }}
                                        </div>
                                    </td>                         
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.bidang }}
                                        </div>
                                    </td>                         
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.bidang }}
                                        </div>
                                    </td>                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.kode_area }}
                                        </div>
                                    </td>                   
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ karyawan.email }}
                                        </div>
                                    </td>
                                                                                                                                                                                        
                                </tr>
                                <!-- More people... -->
                            </tbody>
                            
                        </table>
                        <nav-link class="pagination relative">
                                <ul class="flex">
                                    <li class="page-item px-2">
                                        <button class="page-link" v-if="page != 1" @click="page = 1" > First </button>
                                    </li>
                                    <li class="page-item px-2">
                                        <button class="page-link" v-if="page != 1" @click="page--" > Previous </button>
                                    </li>
                                    <li class="page-item px-2">
                                        <button class="page-link" v-for="pageNumber in pages.slice(page-1, page+5)" :key="pageNumber" @click="page = pageNumber" :class="{'focus:ring-offset-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2': page==pageNumber}"> {{pageNumber}} </button>
                                    </li>
                                    <li class="page-item px-2">
                                        <button @click="page++" v-if="page < pages.length" class="page-link"> Next </button>
                                    </li>
                                    <li class="page-item px-2">
                                        <button class="page-link" v-if="page < pages.length"  @click="page = pages.length" > Last </button>
                                    </li>
                                </ul>
                        </nav-link>
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import Pagination from '@/Jetstream/Pagination'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetCheckbox,
        Pagination
    },
    computed:{
        displayedPosts:function() {
			return this.paginate(this.karyawans);
		}
    },
    watch: {
		karyawans () {
			this.setPages();
		}
	},
	created(){
        this.setPages();
	},

    props: {
        karyawans: Array,
    },

    data() {
        return {
            selectedTim: {},
            term:'',
            page: 1,
			perPage: 15,
            pages:[],
            listKaryawan:this.karyawans,
        }
    },
    methods:{
        search(){
            this.$inertia.replace(this.route('karyawan.index', {term: this.term}))
        },
        setPages () {
			let numberOfPages = Math.ceil(this.karyawans.length / this.perPage);
			for (let index = 1; index <= numberOfPages; index++) {
				this.pages.push(index);
			}
		},
		paginate (posts) {
			let page = this.page;
			let perPage = this.perPage;
			let from = (page * perPage) - perPage;
			let to = (page * perPage);
			return posts.slice(from, to);
		}
    },
    filters: {
		trimWords(value){
			return value.split(" ").splice(0,20).join(" ") + '...';
		}
	}
}
</script>

<style scoped>


    .options{
        white-space: pre-wrap;
        word-wrap: break-word;
        font-family: inherit;
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
    .page-link {
	    display: inline-block;
    }
    .page-link {
        font-size: 20px;
        color: #29b3ed;
        font-weight: 500;
    }
    .offset{
        width: 1000px !important;
        margin: 20px auto;  
    }

    .pagination {
        list-style: none;
        margin: 0;
        padding: 0;
        text-align: center;
    }
    .page-link:not(:disabled):not(.disabled) {
        cursor: pointer;
    }
    button{
        background: #d1e5fa;
        margin: .25rem;
        padding: .25rem .5rem;
        border-radius: 4px;
        text-decoration: none;
        position: relative;
        display: block;
        color: #65a2e9;
    }
    li {
        display: inline-block;
        border: 1px solid #D5D5D5;
        box-sizing: border-box;
        margin-left: -1px; 
    }
    button.page-link {
        font-size: 20px;
        color: #29b3ed;
        font-weight: 500;
        border: black;
        
    }
    button.page-link {
        display: inline-block;
    
    }
            a {
                background: #65a2e9;
                margin: .25rem;
                padding: .25rem .5rem;
                border-radius: 4px;
                text-decoration: none;
                position: relative;
                display: block;
                color: #d1e5fa;
            }    
    
</style>
