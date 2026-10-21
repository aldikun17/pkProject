import { ref } from 'vue'

const theme = ref(document.documentElement.getAttribute('data-theme') || 'light')

export function useTheme(setTheme) {
  function setTheme(t) {
    theme.value = t;
    document.documentElement.setAttribute('data-theme', t)
    try { localStorage.setItem('theme', t) } catch (e) { console.log(e)}
  }
  const toggleTheme = () => setTheme(theme.value === 'dark' ? 'light' : 'dark')
  return { theme, toggleTheme , setTheme }
}
