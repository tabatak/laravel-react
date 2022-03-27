import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route } from 'react-router-dom';

import MainRouter from './MainRouter';
import axios from 'axios';
import Layout from './admin/Layout';

axios.defaults.baseURL = "http://localhost:9000/";
axios.defaults.headers.post['Content-Type'] = 'application/json';
axios.defaults.headers.post['Accept'] = 'application/json';
axios.defaults.withCredentials = true;
axios.interceptors.request.use(function (config) {
    const token = localStorage.getItem('auth_token');
    config.headers.Authorization = token ? `Bearer ${token}` : '';
    return config;
});

function App() {
    return (
        <BrowserRouter>
            <MainRouter />

            <Route path="/admin" name="Admin" render={(props) => <Layout {...props} />} />
        </BrowserRouter>
    )
}

if (document.getElementById('nav')) {
    ReactDOM.render(<App />, document.getElementById('nav'));
}