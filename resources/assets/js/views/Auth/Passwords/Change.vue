<template>
    <div>
        <h1 class="title">Change password</h1>

        <div class="columns">
            <div class="column is-6-widescreen is-7-desktop is-8-tablet">
                <form @submit.prevent="onSubmitChangePassword" @keydown="form.errors.clear($event.target.id)" novalidate>
                    <b-field label="Old Password" label-for="old_password"
                        :type="(form.errors.has('old_password') ? 'is-danger' : '')" :message="form.errors.first('old_password')"
                    >
                        <b-input v-model="form.old_password" type="password" id="old_password" password-reveal/>
                    </b-field>

                    <div class="columns">
                        <div class="column is-half">
                            <b-field label="New password" label-for="password" :addons="false"
                                :type="(form.errors.has('password') ? 'is-danger' : '')" :message="form.errors.first('password')"
                            >
                                <b-input v-model="form.password" type="password" id="password" password-reveal/>
                                <password-meter :password="form.password"/>
                            </b-field>
                        </div>
                        <div class="column is-half">
                            <b-field label="New password confirmation" label-for="password_confirmation">
                                <b-input v-model="form.password_confirmation" type="password" id="password_confirmation" password-reveal/>
                            </b-field>
                        </div>
                    </div>

                    <b-field>
                        <button class="button is-primary" :class="{ 'is-loading': form.processing }" :disabled="form.errors.any()">
                            Change password
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
    metaInfo: { title: 'Change password' },
    components: { PasswordMeter },
    data () {
        return {
            form: new Form([
                'old_password',
                'password',
                'password_confirmation'
            ])
        };
    },
    methods: {
        onSubmitChangePassword () {
            this.form.post('/password/change')
                .then((response) => this.$router.push('/'))
                .catch((error) => console.log(error.response));
        }
    }
};
</script>
