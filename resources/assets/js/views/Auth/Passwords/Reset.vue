<template>
    <div>
        <h1 class="title">Reset password</h1>

        <div class="columns">
            <div class="column is-6-widescreen is-7-desktop is-8-tablet">
                <form @submit.prevent="onSubmitResetPassword" @keydown="form.errors.clear($event.target.id)" novalidate>
                    <b-field label="Email" label-for="email"
                        :type="(form.errors.has('email') ? 'is-danger' : '')" :message="form.errors.first('email')"
                    >
                        <b-input v-model="form.email" type="email" id="email"/>
                    </b-field>

                    <div class="columns">
                        <div class="column is-half">
                            <b-field label="Password" label-for="password" :addons="false"
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
                            Reset password
                        </button>
                    </b-field>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'form-backend-validation';
import PasswordMeter from '@/components/PasswordMeter';

export default {
    metaInfo: { title: 'Reset password' },
    components: { PasswordMeter },
    data () {
        return {
            form: new Form({
                token: this.$route.params.token,
                email: '',
                password: '',
                password_confirmation: ''
            })
        };
    },
    methods: {
        onSubmitResetPassword () {
            this.form.post('/password/reset')
                .then((response) => {
                    this.$store.dispatch('login', response);
                    this.$router.push('/');
                })
                .catch((error) => console.log(error.response));
        }
    }
};
</script>
