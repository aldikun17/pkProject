import { ref } from 'vue'

const small = window.matchMedia('(max-width: 767px)').matches // check max width of the browser
const saved = localStorage.getItem('sidebar') // putting the value of sidebar if toggled in the saved variable
const open = ref(small ? false : saved !== 'closed')

export function useSidebar() {
  function toggle() {
    open.value = !open.value
    if (!window.matchMedia('(max-width: 767px)').matches)
      localStorage.setItem('sidebar', open.value ? 'open' : 'closed')
  }
  return { open, toggle, close: () => (open.value = false) }
}
