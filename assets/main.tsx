import {StrictMode} from 'react'
import {createRoot} from 'react-dom/client'

const container = document.getElementById('react-root')

if (container) {
  const root = createRoot(container)
  root.render(
    <StrictMode>
      <></>
    </StrictMode>,
  )
}
