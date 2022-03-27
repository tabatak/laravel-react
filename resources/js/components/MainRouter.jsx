import React from 'react';
import { Link, useHistory, Switch, Route } from 'react-router-dom';

import UserLogin from './auth/UserLogin';
import UserRegister from './auth/UserRegister';
import AdminRegister from './auth/AdminRegister';
import AdminLogin from './auth/AdminLogin';
import AdminRouter from './admin/AdminRouter';
import UserRouter from './user/UserRouter';

function MainRouter() {
    var AuthButtons = '';
    if (!localStorage.getItem('auth_token')) {
        AuthButtons = (
            <>
                < ul >
                    <li>
                        <Link to="/user/register">
                            <span>User Register</span>
                        </Link>
                    </li>
                    <li>
                        <Link to="/user/login">
                            <span>User Login</span>
                        </Link>
                    </li>
                    <li>
                        <Link to="/admin/register">
                            <span>Admin Register</span>
                        </Link>
                    </li>
                    <li>
                        <Link to="/admin/login">
                            <span>Admin Login</span>
                        </Link>
                    </li>
                </ul >

            </>
        );
    }

    return (
        <>
            Home Page
            {AuthButtons}

            <div>
                <Switch>
                    <Route path="/user/register">
                        <UserRegister />
                    </Route>
                    <Route path="/user/login">
                        <UserLogin />
                    </Route>
                    <Route path="/admin/register">
                        <AdminRegister />
                    </Route>
                    <Route path="/admin/login">
                        <AdminLogin />
                    </Route>
                    <Route path="/user">
                        <UserRouter />
                    </Route>
                </Switch>
            </div>
        </>
    )
}

export default MainRouter;