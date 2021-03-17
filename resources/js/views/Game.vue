<template>
    <div class="game">
        <h1>{{ failedAttempts }}</h1>
        <div class="game__word-cont">
            <span class="game__word-letter" v-for="letter in wordLetters">
                {{ attemptedLetters.includes(letter) ? letter : '_' }}
            </span>
        </div>
        <div class="game__letter-cont" v-if="failedAttempts < 10 && !lettersMatched">
            <button class="game__letter-button" v-for="letter in letters" @click="attemptLetter(letter)">
                {{ letter }}
            </button>
        </div>
        <div class="game__result" v-else-if="lettersMatched">
            <h1>Winner</h1>
            <vs-button @click="newWord">Again</vs-button>
            <vs-button border @click="$router.push('/start-game')">Back</vs-button>
        </div>
        <div class="game__result" v-else-if="hasLost">
            <h1>Loser</h1>
            <vs-button @click="newWord">Again</vs-button>
            <vs-button border @click="$router.push('/start-game')">Back</vs-button>
        </div>
    </div>

</template>

<script>
export default {
    computed: {
        letters() {
            let alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            return alphabet.split("").filter(letter => {
                return !this.attemptedLetters.includes(letter)
            })
        },
        wordLetters() {
            return this.word.split("")
        },
        lettersMatched() {
            let matched = 0
            this.wordLetters.forEach(letter => {
                if (this.attemptedLetters.includes(letter)) {
                    matched++
                }
            })
            return matched === this.wordLetters.length
        },
        hasLost() {
            return this.failedAttempts >= 10
        }
    },
    watch: {
        lettersMatched(newVal, oldVal){
            if(newVal){
                axios.get(`/api/game-won/${this.gameId}`)
                    .then(res => {console.log(res)})
            }
        },
        hasLost(newVal, oldVal) {
            if (newVal) {
                console.log(newVal)
                axios.get(`/api/game-lost/${this.gameId}`)
                    .then(res => {console.log(res)})
            }
        }
    },
    data() {
        return {
            attemptedLetters: [],
            word: "word",
            failedAttempts: 0,
            successfulAttempts: 0,
            gameId: 0

        }
    },
    methods: {
        attemptLetter(letter) {
            if (!this.wordLetters.includes(letter)) {
                this.failedAttempts++
            }
            this.attemptedLetters.push(letter)
        },
        newWord() {
            axios.get('/api/new-game')
                .then(res => {
                    this.attemptedLetters = []
                    this.word = res.data.word
                    this.gameId = res.data.id
                    this.failedAttempts = 0
                    this.successfulAttempts = 0
                    this.successfulAttempts = 0
                })


        },

    },
    mounted() {
        axios.get('/api/new-game')
            .then(res => {
                this.word = res.data.word
                this.gameId = res.data.id
            })
    }
}

</script>

<style lang="scss" scoped>
.game {
    width: 90%;
    max-width: 800px;
    margin: auto;
    display: flex;
    flex-direction: column;

    &__letter-cont {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap;

    }

    &__word-cont {
        padding: 20px 0;
        display: flex;
        justify-content: center;
    }

    &__letter-button {
        background-color: #195cff;
        color: white;
        font-size: 18px;
        border: 2px solid white;
        margin: 10px;
        box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    &__word-letter {
        background-color: lightgrey;
        margin: 5px;
        font-size: 30px;
        padding: 10px;
        border-radius: 5px;
    }

    &__result {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
}
</style>
