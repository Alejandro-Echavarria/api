<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <x-container id="app" class="py-8">
        <x-form-section>
            <x-slot name="title">
                New client
            </x-slot>

            <x-slot name="description">
                Fill the request fields.
            </x-slot>

            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4">
                    <x-input-label>
                        {{ __('Names') }}
                    </x-input-label>

                    <x-text-input v-model="createForm.name" type="text" class="w-full mt-1" />
                </div>
                <div class="col-span-6 sm:col-span-4">
                    <x-input-label>
                        {{ __('Redirection URL') }}
                    </x-input-label>

                    <x-text-input v-model="createForm.redirect" type="text" class="w-full mt-1" />
                </div>
            </div>

            <x-slot name="actions">
                <x-primary-button v-on:click="store">
                    Crear
                </x-primary-button>
            </x-slot>
        </x-form-section>
    </x-container>

    @push('js')
        
        <script>
            new Vue({
                el: "#app",
                data: {
                    createForm: {
                        errors: [],
                        name: null,
                        redirect: null,
                    }
                },
                methods: {
                    store() {
                        axios.post('/oauth/clients', this.createForm).then(response => {
                            
                            this.createForm.name = null;
                            this.createForm.redirect = null;

                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }).catch(error => {
                            // this.createForm.errors = error.response.data.errors;
                        });
                    }
                }
            });
        </script>

    @endpush
</x-app-layout>