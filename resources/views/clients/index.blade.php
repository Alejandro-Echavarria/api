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
                        Create
                    </x-primary-button>
                </x-slot>
            </x-form-section>
    
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
                                    <a class="pr-2 hover:text-green-600 font-semibold cursor-pointer"
                                        v-on:click="show(client)">
                                        View
                                    </a>
                                    <a class="px-2 hover:text-blue-600 font-semibold cursor-pointer"
                                        v-on:click="edit(client)">
                                        Edit
                                    </a>
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

        {{-- Edit client --}}
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
                <x-primary-button 
                    v-on:click="update()"
                    v-bind:disabled="editForm.disabled"
                    class="sm:ml-3">
                    Update
                </x-primary-button>
                <x-secondary-button v-on:click="editForm.open = false" class="sm:ml-3">
                    Cancel
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>

        {{-- Show client --}}
        <x-dialog-modal modal="showForm.open">
            <x-slot name="title">
                Show credentials
            </x-slot>

            <x-slot name="content">
                <div class="space-y-2 text-gray-800 dark:text-gray-200">
                    <p>
                        <span class="font-semibold">Client:</span>
                        <span v-text="showForm.name" class="text-sm select-all"></span>
                    </p>
                    <p>
                        <span class="font-semibold">Client ID:</span>
                        <span v-text="showForm.id" class="text-sm select-all"></span>
                    </p>
                    <p>
                        <span class="font-semibold">Client secret:</span>
                        <span v-text="showForm.secret" class="text-sm break-words select-all"></span>
                    </p>
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button v-on:click="showForm.open = false" class="sm:ml-3">
                    Cancel
                </x-secondary-button>
            </x-slot>
        </x-dialog-modal>
    </div>

    @push('js')
        
        <script>
            new Vue({
                el: "#app",
                data: {
                    clients: [],
                    showForm: {
                        open: false,
                        id: null,
                        name: null,
                        secret: null,
                    },
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
                        id: null,
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
                    show(client) {

                        this.showForm.open = true;
                        this.showForm.id = client.id;
                        this.showForm.name = client.name;
                        this.showForm.secret = client.secret;
                    },
                    store() {

                        this.createForm.disabled = true;
                        axios.post('/oauth/clients', this.createForm).then(response => {
                            
                            this.createForm.name = null;
                            this.createForm.redirect = null;
                            this.createForm.errors = [];

                            this.show(response.data);

                            this.createForm.disabled = false;
                            this.getClients();
                        }).catch(error => {

                            this.createForm.errors = error.response.data.errors;
                            this.createForm.disabled = false;
                        });
                    },
                    edit(client) {

                        this.editForm.open = true;
                        this.editForm.errors = [];
                        this.editForm.id = client.id;
                        this.editForm.name = client.name;
                        this.editForm.redirect = client.redirect;
                    },
                    update() {

                        this.editForm.disabled = true;
                        axios.put('/oauth/clients/' + this.editForm.id, this.editForm).then(response => {

                            this.editForm.open = false;
                            this.editForm.disabled = false;
                            this.editForm.name = null;
                            this.editForm.redirect = null;
                            this.editForm.errors = [];

                            Swal.fire(
                                'Updated successfully!',
                                'Your client was successfully Updated.',
                                'success'
                            );

                            this.getClients();
                        }).catch(error => {

                            this.editForm.errors = error.response.data.errors;
                            this.editForm.disabled = false;
                        });
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