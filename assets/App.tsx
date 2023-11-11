import React, { StrictMode } from "react";
import ReactDOM from "react-dom/client";
import {Routes, Route, BrowserRouter} from 'react-router-dom'
import Home from "./pages/Home";

export default function App() {

    return(
        <Routes>
            <Route path={"/"} element={<Home />} />
        </Routes>
    )

}

const appDiv: HTMLElement|null = document.getElementById("app")
if(appDiv !== null) {
    const root = ReactDOM.createRoot(appDiv)
    root.render(
        <StrictMode>
            <BrowserRouter>
                <App />
            </BrowserRouter>
        </StrictMode>
    )
}