<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('API Tokens') }}
        </h2>
    </x-slot>

    <div id="app">
        <x-container>

            {{-- Create Access Token --}}
            <x-form-section class="py-8">

                <x-slot name="title">
                    New access token
                </x-slot>

                <x-slot name="description">
                    Here you can generate new access tokens.
                </x-slot>

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <x-input-label>
                            {{ __('Name') }}
                        </x-input-label>

                        <x-text-input v-model="createForm.name" type="text" class="w-full mt-1" />
                        <x-input-error-vue class="mt-2" object="createForm" property="name" />
                    </div>
                </div>

                <x-slot name="actions">
                    <x-primary-button v-on:click="store" v-bind:disabled="createForm.disabled">
                        Create
                    </x-primary-button>
                </x-slot>

            </x-form-section>

            {{-- Show Access Tokens --}}
            <x-form-section v-if="tokens.length > 0">

                <x-slot name="title">
                    Access tokens list
                </x-slot>
    
                <x-slot name="description">
                    All creaeted access token.
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
                            <tr v-for="token in tokens">
                                <td class="py-2">
                                    @{{ token.name }}
                                </td>
                                <td class="flex py-2 divide-x divide-gray-100 dark:divide-gray-700">
                                    <a class="pr-2 hover:text-green-600 font-semibold cursor-pointer"
                                        v-on:click="show(token)">
                                        View
                                    </a>
                                    <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer"
                                        v-on:click="revoke(token)">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-form-section>
        </x-container>

        {{-- Show access token --}}
        <x-dialog-modal modal="showForm.open">
            <x-slot name="title">
                Show credentials
            </x-slot>

            <x-slot name="content">
                <div class="space-y-2 text-gray-800 dark:text-gray-200">
                    <p>
                        <span class="font-semibold">Access token:</span>
                        <span v-text="showForm.id" class="text-sm break-words select-all"></span>
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
                el: '#app',
                data: {
                    tokens: [],
                    createForm: {
                        name: null,
                        errors: [],
                        disabled: false,
                    },
                    showForm: {
                        open: false,
                        id: null,
                    }
                },
                mounted() {
                    this.getTokens();
                },
                methods: {
                    getTokens() {

                        axios.get('/oauth/personal-access-tokens').then(response => {

                            this.tokens = response.data;
                        });
                    },
                    show(token) {

                        this.showForm.open = true;
                        this.showForm.id = token.id;
                    },
                    store() {

                        this.createForm.disabled = true;
                        axios.post('/oauth/personal-access-tokens', this.createForm).then(response => {

                            this.createForm.name = null;
                            this.createForm.errors = [];
                            this.createForm.disabled = false;
                            this.getTokens();
                        }).catch(error => {

                            this.createForm.errors = error.response.data.errors;
                            this.createForm.disabled = false;
                        })
                    },
                    revoke(token) {

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

                                axios.delete('/oauth/personal-access-tokens/' + token.id).then(response => {

                                    this.getTokens();
                                });

                                Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                                )
                            }
                        });
                    }
                },
            });
        </script>

    @endpush

</x-app-layout>