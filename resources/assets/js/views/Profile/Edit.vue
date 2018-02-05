<template>
    <div>
        <h1>Update your profile</h1>

        <div class="columns">
            <div class="column is-6">
                <form @submit.prevent="onSubmitUpdate" @keydown="form.errors.clear($event.target.id)" novalidate>
                    <div class="columns">
                        <div class="column is-half">
                            <b-field label="Firstname" label-for="firstname"
                                :type="(form.errors.has('firstname') ? 'is-danger' : '')" :message="form.errors.first('firstname')"
                            >
                                <b-input v-model="form.firstname" id="firstname"/>
                            </b-field>
                        </div>
                        <div class="column is-half">
                            <b-field label="Lastname" label-for="lastname"
                                :type="(form.errors.has('lastname') ? 'is-danger' : '')" :message="form.errors.first('lastname')"
                            >
                                <b-input v-model="form.lastname" id="lastname"/>
                            </b-field>
                        </div>
                    </div>

                    <b-field label="Location" label-for="location"
                        :type="(form.errors.has('location') ? 'is-danger' : '')" :message="form.errors.first('location')"
                    >
                        <b-input v-model="form.location" id="location"/>
                    </b-field>

                    <b-field>
                        <button class="button is-primary" :class="{ 'is-loading': form.processing }" :disabled="form.errors.any()">
                            Update
                        </button>
                    </b-field>
                </form>
            </div>
        </div><!-- .columns -->
    </div>
</template>

<script>
import Form from 'form-backend-validation';

export default {
    metaInfo: { title: 'Update your profile' },
    data () {
        return {
            form: new Form([
                'firstname',
                'lastname',
                'location'
            ], { resetOnSuccess: false })
        };
    },
    methods: {
        onSubmitUpdate () {
            this.form.put('/profile')
                .then((response) => this.$store.commit('setUser', Object.assign({}, this.$_auth.user, this.form.data())))
                .catch((error) => console.log(error.response));
        }
    },
    created () {
        this.form.populate(this.$_auth.user);
    }
};
</script>
