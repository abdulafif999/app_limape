<template>
    <div >
        <green-button @click="createTim">
            Buat Tim Baru
        </green-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingTim" @close="closeModal">
            <template #title>
                Create Tim
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Tim"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
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
        GreenButton
    },

    data() {
        return {
            creatingTim: false,

            form: this.$inertia.form({
                nama: '',
            })
        }
    },

    methods: {
        createTim() {
            this.creatingTim = true;

            setTimeout(() => this.$refs.nama.focus(), 250)
        },

        create() {
            this.form.post(route('tim.store'), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nama.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.creatingTim = false

            this.form.reset()
        },
    },
}
</script>
