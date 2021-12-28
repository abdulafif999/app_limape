<template>
    <div>
        <green-button @click="createKriteria">
            New Kriteria
        </green-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingKriteria" @close="closeModal">
            <template #title>
                Create Kriteria
            </template>

            <template #content>
                <div class="mt-4">
                    <select  class="block w-52 text-gray-700 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="form.nama">
                                        
                        <option value="" disabled selected>Select Kriteria</option>
                        <option value="P1">P1</option>
                        <option value="P2">P2</option>
                        <option value="P3">P3</option>
                        <option value="P4">P4</option>
                        <option value="P5">P5</option>
                    </select>

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Sub Kriteria"
                                ref="sub_kriteria"
                                v-model="form.sub_kriteria"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.sub_kriteria" class="mt-2" />
                </div>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Keterangan"
                                ref="keterangan"
                                v-model="form.keterangan"
                                @keyup.enter="create" />

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
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import GreenButton from '@/Components/GreenButton.vue'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        GreenButton,
    },

    data() {
        return {
            creatingKriteria: false,

            form: this.$inertia.form({
                nama: '',
                sub_kriteria: '',
                keterangan: ''
            })
        }
    },

    methods: {
        createKriteria() {
            this.creatingKriteria = true;

            setTimeout(() => this.$refs.nama.focus(), 250)
        },

        create() {
            this.form.post(route('kriteria.store'), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nama.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.creatingKriteria = false

            this.form.reset()
        },
    },
}
</script>
