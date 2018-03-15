<template>
    <div>
        <h1 class="title">Sign up</h1>

        <div class="columns">
            <div class="column is-6-widescreen is-7-desktop is-8-tablet">
                <form @submit.prevent="onSubmitSignup" @keydown="form.errors.clear($event.target.id)" novalidate>
                    <b-field label="Your email address" label-for="email"
                        :type="(form.errors.has('email') ? 'is-danger' : '')" :message="form.errors.first('email')"
                    >
                        <b-input v-model="form.email" type="email" id="email"/>
                    </b-field>

                    <b-field label="Choose a username" label-for="username"
                        :type="(form.errors.has('username') ? 'is-danger' : '')" :message="form.errors.first('username')"
                    >
                        <b-input v-model="form.username" id="username"/>
                    </b-field>

                    <div class="columns">
                        <div class="column is-half">
                            <b-field label="Your firstname" label-for="firstname"
                                :type="(form.errors.has('firstname') ? 'is-danger' : '')" :message="form.errors.first('firstname')"
                            >
                                <b-input v-model="form.firstname" id="firstname"/>
                            </b-field>
                        </div>
                        <div class="column is-half">
                            <b-field label="Your lastname" label-for="lastname"
                                :type="(form.errors.has('lastname') ? 'is-danger' : '')" :message="form.errors.first('lastname')"
                            >
                                <b-input v-model="form.lastname" id="lastname"/>
                            </b-field>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column is-half">
                            <b-field label="Choose a password" label-for="password" :addons="false"
                                :type="(form.errors.has('password') ? 'is-danger' : '')" :message="form.errors.first('password')"
                            >
                                <b-input v-model="form.password" type="password" id="password" password-reveal/>
                                <password-meter :password="form.password"/>
                            </b-field>
                        </div>
                        <div class="column is-half">
                            <b-field label="Password confirmation" label-for="password_confirmation">
                                <b-input v-model="form.password_confirmation" type="password" id="password_confirmation" password-reveal/>
                            </b-field>
                        </div>
                    </div>

                    <b-field>
                        <button class="button is-primary" :class="{ 'is-loading': form.processing }" :disabled="form.errors.any()">
                            Sign up
                        </button>
                    </b-field>
                </form>
            </div>
        </div><!-- .columns -->
    </div>
</template>

<script>
import Form from 'form-backend-validation';
import PasswordMeter from '@/components/PasswordMeter';

export default {
    metaInfo: { title: 'Sign up' },
    components: { PasswordMeter },
    data () {
        return {
            form: new Form([
                'email',
                'username',
                'firstname',
                'lastname',
                'password',
                'password_confirmation'
            ])
        };
    },
    methods: {
        onSubmitSignup () {
            this.form.post('/register')
                .then((response) => {
                    this.$store.dispatch('login', response);
                    this.$router.push('/');
                })
                .catch((error) => console.log(error.response));
        }
    }
};
</script>
