import Login from './views/Login'
import Register from './views/Register'
import StartGame from './views/StartGame'
import Game from './views/Game'

const routes = [
    {
        path: '/',
        component: Login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/register',
        component: Register,
        meta: {
            requiresAuth: false
        }

    },
    {
        path: '/start-game',
        component: StartGame,
        meta: {
            requiresAuth: true
        }

    },
    {
        path: '/game',
        component: Game,
        meta: {
            requiresAuth: true
        }

    },
]

export default routes
