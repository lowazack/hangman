<template>
    <div class="game">
        <div class="game__svg-cont">
            <svg height="400" width="400">
                <g id="body">
                    <g id="head" v-if="failedAttempts >= 5">
                        <circle cx="200" cy="80" r="20" stroke="black" stroke-width="4" fill="white"/>
                        <g id="rEyes">
                            <circle cx="193" cy="80" r="4"/>
                            <circle cx="207" cy="80" r="4"/>
                        </g>
                        <g id="xEyes" class="hide">
                            <line x1="190" y1="78" x2="196" y2="84"/>
                            <line x1="204" y1="78" x2="210" y2="84"/>
                            <line x1="190" y1="84" x2="196" y2="78"/>
                            <line x1="204" y1="84" x2="210" y2="78"/>
                        </g>
                    </g>
                    <line x1="200" y1="100" x2="200" y2="150" v-if="failedAttempts >= 6"/>
                    <line id="armL" x1="200" y1="120" x2="170" y2="140" v-if="failedAttempts >= 7"/>
                    <line id="armR" x1="200" y1="120" x2="230" y2="140" v-if="failedAttempts >= 8"/>
                    <line id="legL" x1="200" y1="150" x2="180" y2="190" v-if="failedAttempts >= 9"/>
                    <line id="legR" x1="200" y1="150" x2="220" y2="190" v-if="failedAttempts >= 10"/>
                </g>
                <line x1="10" y1="250" x2="150" y2="250" v-if="failedAttempts >= 1"/>
                <line id="door1" x1="150" y1="250" x2="200" y2="250" v-if="failedAttempts >= 1"/>
                <line  id="door2" x1="200" y1="250" x2="250" y2="250" v-if="failedAttempts >= 1"/>
                <line x1="250" y1="250" x2="390" y2="250" v-if="failedAttempts >= 1"/>
                <line x1="100" y1="250" x2="100" y2="20" v-if="failedAttempts >= 2"/>
                <line x1="100" y1="20" x2="200" y2="20" v-if="failedAttempts >= 3"/>
                <line id="rope" x1="200" y1="20" x2="200" y2="60" v-if="failedAttempts >= 4"/>
            </svg>
        </div>
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
            }
        },
        hasLost(newVal, oldVal) {
            if (newVal) {
                console.log(newVal)
                axios.get(`/api/game-lost/${this.gameId}`)
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

    &__svg-cont {
        display: flex;
        justify-content: center;
        align-items: flex-end;
    }

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

    line {
        stroke: black;
        stroke-width: 4;
    }
}
</style>
