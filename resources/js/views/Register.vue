<template>
    <div class="entry">
        <div>
            <vs-input class="entry__input" v-model="formObject.email" type="email" placeholder="email"/>
            <vs-input class="entry__input" placeholder="name" v-model="formObject.name"/>
            <vs-input class="entry__input" type="password" placeholder="password" v-model="formObject.password"/>
            <vs-button @click="submitForm">Register</vs-button>
            <hr>
            <vs-button border @click="$router.push('/')">Login</vs-button>
        </div>

    </div>
</template>

<script>
export  default {
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
            axios.post('/api/register', this.formObject)
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
