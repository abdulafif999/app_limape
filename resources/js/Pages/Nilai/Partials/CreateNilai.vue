<template>
    <div>
        <green-button @click="createNilai">
            Buat Rank Penilaian
        </green-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingNilai" @close="closeModal">
            <template #title>
                Create Nilai
            </template>

            <template #content>


                <div class="mt-4">
                    <select class="block w-10/12 py-2 border text-left border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="form.kriteria_id" >
                        <option value="" disabled selected>Select Category</option>
                        <option v-for="kriteria in kriterias" :key="kriteria.id" :value="kriteria.id">{{kriteria.nama}} {{'-'}} {{ kriteria.sub_kriteria }}</option>
                    </select>

                    <jet-input-error :message="form.errors.kriteria_id" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="form.nilai_bawah"
                                @keyup.enter="create" min="0" max="100"/>

                    <jet-input-error :message="form.errors.nilai_bawah" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="form.nilai_atas"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nilai_atas" class="mt-2" />
                </div>                

                <div class="mt-4">
                    <textarea class="flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                placeholder="Keterangan"
                                ref="keterangan"
                                v-model="form.keterangan"
                                rows="4"
                                cols="50">
                    </textarea>

                    <jet-input-error :message="form.errors.keterangan" class="mt-2" />
                </div>
            </template>

            <template #footer>
                <div class="flex">
                    <jet-secondary-button @click="closeModal">
                        Cancel
                    </jet-secondary-button>

                    <green-button class="ml-2" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Create
                    </green-button>
                </div>
            </template>
        </jet-dialog-modal>
    </div>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import GreenButton from '@/Components/GreenButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        GreenButton,
    },

    props: {
        kriterias: Array
    },

    data() {
        return {
            creatingNilai: false,

            form: this.$inertia.form({
                kriteria_id: '',
                nilai_bawah: '',
                nilai_atas: '',
                keterangan: '',
            })
        }
    },

    mounted () {
    },

    methods: {
        createNilai() {
            this.fetchKriterias();
            this.creatingNilai = true;

            setTimeout(() => this.$refs.nilai.focus(), 250)
        },

        fetchKriterias() {
            Inertia.reload({ only: ['kriterias'] })
        },

        create() {
            this.form.post(route('nilai.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
            })
        },

        closeModal() {
            this.creatingNilai = false
            this.form.clearErrors()
            this.form.reset()
        },
    },
}
</script>
