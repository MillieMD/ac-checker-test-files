import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import App from './App.js'

let root : HTMLElement | null = document.getElementById('root');

if(root){
  createRoot(root).render(
    <StrictMode>
      <App />
    </StrictMode>,
)
}


