<template>
    <div>
        <green-button @click="createTimUnit">
            Buat Tim Baru
        </green-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingTimUnit" @close="closeModal">
            <template #title>
                Buat Tim 5P/Unit Baru
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Tim"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Unit"
                                ref="nama"
                                v-model="form.unit"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.unit" class="mt-2" />

                    <jet-input-error :message="form.errors.unit" class="mt-2" />
                </div>

                <div class="mt-4">
                    <select class="block w-10/12 py-2 border text-left border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500"
                        v-model="form.kategori" >
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Operasional">Operasional</option>
                        <option value="Non-Operasional">Non-Operasional</option>
                    </select>

                    <jet-input-error :message="form.errors.kategori" class="mt-2" />
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
import { Inertia } from '@inertiajs/inertia'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        GreenButton
    },

    data() {
        return {
            creatingTimUnit: false,

            form: this.$inertia.form({
                nama: '',
                unit: '',
                kategori:'',
            })
        }
    },

    mounted () {
    },

    methods: {
        createTimUnit() {
            this.creatingTimUnit = true;
        },

        create() {
            this.form.post(route('timUnit.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
                onError:() => this.$refs.nama.focus()
            })
        },

        closeModal() {
            this.creatingTimUnit = false
            this.form.clearErrors()
            this.form.reset()
        },

    },
}
</script>
