<template>
    <div class="start-game">
        <vs-button @click="$router.push('/game')">Start Game</vs-button>
        <vs-button @click="logout">Logout</vs-button>
        <vs-table>
            <template #thead>
                <vs-tr>
                    <vs-th>
                        Name
                    </vs-th>
                    <vs-th>
                        Word
                    </vs-th>
                    <vs-th>
                        difficulty
                    </vs-th>
                    <vs-th>
                        Time
                    </vs-th>
                    <vs-th>
                        Outcome
                    </vs-th>
                </vs-tr>
            </template>
            <template #tbody>
                <vs-tr v-for="game in games" :key="game.id" :data="game">
                    <vs-td>
                        {{ game.user.name }}
                    </vs-td>
                    <vs-td>
                        {{game.word}}
                    </vs-td>
                    <vs-td>
                        {{ game.difficulty }}
                    </vs-td>
                    <vs-td>
                        {{ game.duration }}
                    </vs-td>
                    <vs-td>
                        {{ game.hasLost ? "Lost" : "Won" }}
                    </vs-td>
                </vs-tr>
            </template>
        </vs-table>
    </div>
</template>

<script>
export  default {
    data(){
        return {
            games: []
        }
    },
    mounted() {
        axios.get('/api/games')
            .then(res => {
                this.games = res.data;
            })
    },
    methods: {
        logout() {
            document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });
            this.$store.commit('logout')
            this.$router.push('/')
        }
    }
}
</script>

<style lang="scss" scoped>
.start-game {
    height: 100vh;
    display: flex;
    align-items: center;
    flex-direction: column;

}
</style>
