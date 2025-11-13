import {createApp} from "vue"
import router from "./router/index.js"
import App from "./components/App.vue"
import "./bootstrap.js"

const link = document.createElement("link")
link.rel = "icon"
link.type = "image/png"
link.href = "/favicon.ico"
document.head.appendChild(link)

const app = createApp(App)

app.use(router)
app.mount("#app")
