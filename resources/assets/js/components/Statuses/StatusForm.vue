<template>
    <form @submit.prevent="onSubmitStatus" @keydown="form.errors.clear($event.target.id)" novalidate>
        <b-field :type="(form.errors.has('body') ? 'is-danger' : '')" :message="form.errors.first('body')">
            <b-input v-model="form.body" type="textarea" id="body" :placeholder="placeholder" maxlength="300"/>
        </b-field>

        <b-field>
            <button class="button is-primary" :class="{ 'is-loading': form.processing }" :disabled="form.errors.any()">
                {{ button }}
            </button>
        </b-field>
    </form>
</template>

<script>
import Form from 'form-backend-validation';

export default {
    props: {
        placeholder: {
            type: String,
            default: ''
        },
        button: {
            type: String,
            default: 'Post'
        },
        parentId: {
            type: Number,
            default: 0
        }
    },
    data () {
        return { form: new Form(['body']) };
    },
    computed: {
        endpoint () {
            return '/statuses' + (this.parentId > 0 ? `/${this.parentId}/replies` : '');
        },
        type () {
            return (this.parentId > 0 ? 'reply' : 'status');
        }
    },
    methods: {
        onSubmitStatus () {
            this.form.post(this.endpoint)
                .then((response) => this.$emit(`${this.type}-posted`, response[this.type]))
                .catch((error) => console.log(error.response));
        }
    }
};
</script>
