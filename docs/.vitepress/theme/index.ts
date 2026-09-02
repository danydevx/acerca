import DefaultTheme from 'vitepress/theme'
import Layout from './Layout.vue'
import DemoFrame from './components/DemoFrame.vue'
import './style.css'

export default {
  extends: DefaultTheme,
  Layout,
  enhanceApp({ app }) {
    app.component('DemoFrame', DemoFrame)
  }
}
