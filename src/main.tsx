import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import { createBrowserRouter, RouterProvider, ScrollRestoration } from 'react-router-dom';
import Header from './components/Header/Header.tsx';
import Footer from './components/Footer/Footer.tsx';
import Home from './components/Home/Home.tsx';
import Login from './components/Login/Login.tsx';
import Search from './components/Search/Search.tsx';
import Reviews from './components/Reviews/Reviews.tsx';
import './index.css';

const router = createBrowserRouter([
    {
        path: '/',
        element: (
            <>  
                <Header />
                <Home />
                <Footer />
                <ScrollRestoration />
            </>
        )
    },

    {
        path: '/login',
        element: (
            <>
                <Header/>
                <Login/>
                <Footer/>
            </>
        )
    },

    {
        path: '/search/:q',
        element: (
            <>
                <Header/>
                <Search/>
                <Footer/>
            </>
        )
    },

    {
        path: '/reviews/:id',
        element: (
            <>
                <Header/>
                <Reviews/>
                <Footer/>
                <ScrollRestoration/>
            </>
        )
    }
]);

createRoot(document.getElementById('root')!).render(
    <StrictMode>
        <RouterProvider router={router}/>
    </StrictMode>,
)