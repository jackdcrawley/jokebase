<template>
    <v-app>
        <v-app-bar dark app>
            <v-toolbar-title>JokeBase</v-toolbar-title>
        </v-app-bar>
        <v-dialog
            v-model="showAddModal"
            width="500"
        >
            <v-card>
                <h2 class="px-8 pt-8">Add New Joke</h2>
                <v-text-field
                    label="Type"
                    placeholder="Programming"
                    v-model="newType"
                    class="px-8 pt-6"
                ></v-text-field>
                <v-text-field
                    label="Setup"
                    placeholder="Why did the..."
                    v-model="newSetup"
                    class="px-8"
                ></v-text-field>
                <v-text-field
                    label="Punchline"
                    placeholder="Because..."
                    v-model="newPunchline"
                    class="px-8"
                ></v-text-field>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        v-on:click="save"
                    >
                        Save Joke
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-main>
            <v-container fluid>
                <v-data-table
                    :headers="headers"
                    :items="jokes"
                    item-key="name"
                    class="elevation-3 mb-16"
                />
                <v-btn
                    @click="showAddModal = true"
                    color="darken-2"
                    dark
                    fixed
                    bottom
                    right
                    fab
                >
                    <v-icon>
                        mdi-plus
                    </v-icon>
                </v-btn>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                headers: [
                    { text: 'Type', value: 'type' },
                    { text: 'Setup', value: 'setup' },
                    { text: 'Punchline', value: 'punchline' },
                ],
                jokes: [],
                showAddModal: false,
                newType: '',
                newSetup: '',
                newPunchline: ''
            }
        },
        mounted() {
            axios.get('/api/jokes').then((res) => {
                const { data: jokes } = res.data;
                this.jokes = jokes;
            });
        },
        methods: {

            /** Store new joke */
            save() {
                const data = new FormData();

                // build payload
                data.append('type', this.newType);
                data.append('setup', this.newSetup);
                data.append('punchline', this.newPunchline);

                axios.post('/api/jokes', data).then((res) => {
                    this.jokes.push({
                        type: this.newType,
                        setup: this.newSetup,
                        punchile: this.newPunchline
                    });

                    this.newType = '';
                    this.newSetup = '';
                    this.newPunchline = '';

                    this.showAddModal = false;
                });

                // TODO: Validation handling
            }
        }
    }
</script>
