<template>
    <div class="entry">
        <div>
            <vs-input class="entry__input" :loading="loading" placeholder="email" v-model="formObject.email"/>
            <vs-alert relief color="danger" v-if="errors.email">
                <div v-for="error in errors.email">{{error}}</div>
            </vs-alert>
            <vs-input class="entry__input" :loading="loading" placeholder="password" v-model="formObject.password"/>
            <vs-alert relief color="danger" v-if="errors.password">
                <div v-for="error in errors.password">{{error}}</div>
            </vs-alert>
            <vs-button @click="submitForm">Login</vs-button>
            <hr>
            <vs-button border @click="$router.push('/register')">Register</vs-button>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            formObject: {},
            errors: {}
        }
    },
    methods: {
        submitForm() {
            this.loading = true
            axios.post('/api/login', this.formObject)
                .then(res => {
                    this.$store.commit('setUser', res.data.logged_in_user)
                    this.$router.push('/start-game')
                })
                .catch(err => {
                    this.errors = err.response.data.errors;
                })
                .finally(() => {
                        this.loading = false
                    }
                )
            console.log(this.formObject)
        }
    }
}
</script>

<style lang="scss" scoped>
.entry {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;

    &__input {
        margin-bottom: 10px;
    }

}
</style>
