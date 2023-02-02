<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>
    
    <div id="app">
        <x-container class="py-8">
    
            {{-- Create client --}}
            <x-form-section class="mb-12">
                <x-slot name="title">
                    New client
                </x-slot>
    
                <x-slot name="description">
                    Fill the request fields.
                </x-slot>
    
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <x-input-label>
                            {{ __('Name') }}
                        </x-input-label>
    
                        <x-text-input v-model="createForm.name" type="text" class="w-full mt-1" />
                        <x-input-error-vue class="mt-2" object="createForm" property="name" />
                    </div>
                    <div class="col-span-6 sm:col-span-4">
                        <x-input-label>
                            {{ __('Redirection URL') }}
                        </x-input-label>
    
                        <x-text-input v-model="createForm.redirect" type="text" class="w-full mt-1" />
                        <x-input-error-vue class="mt-2" object="createForm" property="redirect" />
                    </div>
                </div>
    
                <x-slot name="actions">
                    <x-primary-button v-on:click="store" v-bind:disabled="createForm.disabled">
                        Crear
                    </x-primary-button>
                </x-slot>
            </x-form-section>
    
            {{-- Edit client --}}
            <x-form-section v-if="clients.length > 0">
                <x-slot name="title">
                    Clients list
                </x-slot>
    
                <x-slot name="description">
                    All creaeted clients.
                </x-slot>
    
                <div class="">
                    <table>
                        <thead class="border-b border-gray-100 dark:border-gray-700">
                            <tr class="text-left">
                                <th class="py-2 w-full">Names</th>
                                <th class="py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <tr v-for="client in clients">
                                <td class="py-2">
                                    @{{ client.name }}
                                </td>
                                <td class="flex py-2 divide-x divide-gray-100 dark:divide-gray-700">
                                    <a class="pr-2 hover:text-blue-600 font-semibold cursor-pointer"
                                        v-on:click="edit(client)">Edit</a>
                                    <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer"
                                        v-on:click="destroy(client)">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-form-section>
        </x-container>
    
        <x-dialog-modal modal="editForm.open">
            <x-slot name="title">
                Edit client
            </x-slot>
    
            <x-slot name="content">
                <div class="space-y-6">
                    <div>
                        <x-input-label>
                            {{ __('Name') }}
                        </x-input-label>
    
                        <x-text-input v-model="editForm.name" type="text" class="w-full mt-1" />
                        <x-input-error-vue class="mt-2" object="editForm" property="name"/>
                    </div>
                    <div>
                        <x-input-label>
                            {{ __('Redirection URL') }}
                        </x-input-label>
    
                        <x-text-input v-model="editForm.redirect" type="text" class="w-full mt-1" />
                        <x-input-error-vue class="mt-2" object="editForm" property="redirect"/>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <button type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-gray-200 dark:text-gray-200 shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm">Actualizar</button>
                <button v-on:click="editForm.open = false" type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
            </x-slot>
        </x-dialog-modal>
    </div>

    @push('js')
        
        <script>
            new Vue({
                el: "#app",
                data: {
                    clients: [],
                    createForm: {
                        disabled: false,
                        errors: [],
                        name: null,
                        redirect: null,
                    },
                    editForm: {
                        open: false,
                        disabled: false,
                        errors: [],
                        name: null,
                        redirect: null,
                    }
                },
                mounted() {
                    this.getClients();
                },
                methods: {
                    getClients() {
                        axios.get('/oauth/clients').then(response => {
                            
                            this.clients = response.data;
                        });
                    },
                    store() {
                        this.createForm.disabled = true;
                        axios.post('/oauth/clients', this.createForm).then(response => {
                            
                            this.createForm.name = null;
                            this.createForm.redirect = null;
                            this.createForm.errors = [];

                            Swal.fire(
                                'Created successfully!',
                                'Your client was successfully created.',
                                'success'
                            );

                            this.createForm.disabled = false;
                            this.getClients();
                        }).catch(error => {

                            this.createForm.errors = error.response.data.errors;
                            this.createForm.disabled = false;
                        });
                    },
                    edit(client) {
                        this.editForm.open = true;
                    },
                    destroy(client) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {

                                axios.delete('/oauth/clients/' + client.id).then(response => {

                                    this.getClients();
                                });

                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                            }
                        });
                    }
                }
            });
        </script>

    @endpush
</x-app-layout>