<template>
    <div class="game">
        <h1>{{failedAttempts}}</h1>
        <div class="game__word-cont">
            <span class="game__word-letter" v-for="letter in wordLetters">
                {{ attemptedLetters.includes(letter)? letter : '_' }}
            </span>
        </div>
        <div class="game__letter-cont">
            <button class="game__letter-button" v-for="letter in letters" @click="attemptLetter(letter)">
                {{ letter }}
            </button>
        </div>
    </div>

</template>

<script>
export default  {
    computed: {
        letters()  {
            let alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

            return alphabet.split("").filter(letter => {
                return !this.attemptedLetters.includes(letter)
            })
        },
        wordLetters() {
            return this.word.split("")
        }
    },
    data(){
        return {
            attemptedLetters: [],
            word: "CHARRIOTT",
            failedAttempts: 0
        }
    },
    methods: {
        attemptLetter(letter){
            if(!this.wordLetters.includes(letter)){
                this.failedAttempts ++
            }
            this.attemptedLetters.push(letter)
        }
    },
    mounted(){

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
        box-shadow: 0px 2px 5px 0px rgba(0,0,0,0.2);
        border-radius: 5px;
    }

    &__word-letter {
        background-color: lightgrey;
        margin: 5px;
        font-size: 30px;
        padding: 10px;
        border-radius: 5px;
    }
}
</style>
