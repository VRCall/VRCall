import { BrowserRouter, Routes, Route } from 'react-router-dom'
import Register from './pages/Register'
import Login from './pages/Login'
import './App.scss'
import AuthGuard from './components/guards/AuthGuard'

function App() {
  
  return (
    <BrowserRouter>
      <AuthGuard>
        <Routes>
          <Route path="register" element={<Register />} />
          <Route path="login" element={<Login />} />
        </Routes>
      </AuthGuard>
    </BrowserRouter>
  )
}

export default App
