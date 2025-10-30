import { createApp } from "vue"
import router from "./router/index.js"
import App from "./components/App.vue"
import "./bootstrap.js"

const app = createApp(App)

app.use(router)
app.mount("#app")
