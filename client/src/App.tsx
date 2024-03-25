import { BrowserRouter, Routes, Route } from 'react-router-dom'
import Register from './pages/Register'
import './App.scss'

function App() {
  
  return (
    <BrowserRouter>
      <Routes>
        <Route path="register" element={<Register />} />
      </Routes>
    </BrowserRouter>
  )
}

export default App
