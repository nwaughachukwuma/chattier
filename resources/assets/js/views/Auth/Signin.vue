<template>
    <div>
        <h1 class="title">Sign in</h1>

        <div class="columns">
            <div class="column is-6-widescreen is-7-desktop is-8-tablet">
                <form @submit.prevent="onSubmitSignin" @keydown="form.errors.clear($event.target.id)" novalidate>
                    <b-field label="Email" label-for="email"
                        :type="(form.errors.has('email') ? 'is-danger' : '')" :message="form.errors.first('email')"
                    >
                        <b-input v-model="form.email" type="email" id="email"/>
                    </b-field>

                    <b-field label="Password" label-for="password"
                        :type="(form.errors.has('password') ? 'is-danger' : '')" :message="form.errors.first('password')"
                    >
                        <b-input v-model="form.password" type="password" id="password" password-reveal/>
                    </b-field>

                    <b-field>
                        <button class="button is-primary" :class="{ 'is-loading': form.processing }" :disabled="form.errors.any()">
                            Sign in
                        </button>
                        <router-link to="/password/reset" class="button is-text">Forgot your password?</router-link>
                    </b-field>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'form-backend-validation';

export default {
    metaInfo: { title: 'Sign in' },
    data () {
        return { form: new Form(['email', 'password']) };
    },
    methods: {
        onSubmitSignin () {
            this.form.post('/login')
                .then((response) => {
                    this.$store.dispatch('login', response);
                    this.$router.push(window.storage.pull('url.intended') || '/');
                })
                .catch((error) => console.log(error.response));
        }
    }
};
</script>
