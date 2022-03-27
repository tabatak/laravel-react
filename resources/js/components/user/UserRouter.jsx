import React from 'react';
import { Link, useHistory, Switch, Route } from 'react-router-dom';
import axios from 'axios';
import swal from 'sweetalert';

import Top from './Top';

function UserRouter() {

    const history = useHistory();

    const logoutSubmit = (e) => {
        e.preventDefault();

        axios.post(`/api/user/logout`).then(res => {
            if (res.data.status === 200) {
                localStorage.removeItem('auth_token', res.data.token);
                localStorage.removeItem('auth_name', res.data.username);
                swal("ログアウトしました", res.data.message, "success");
                history.push('/');
                location.reload();
            }
        });
    }

    var AuthButtons = '';

    if (localStorage.getItem('auth_token')) {
        AuthButtons = (
            <li>
                <div onClick={logoutSubmit}>
                    <span>ログアウト</span>
                </div>
            </li>
        );
    }

    return (
        <>
            User Page
            < ul >
                <li>
                    <Link to="/user">
                        <span>Top</span>
                    </Link>
                </li>
                {AuthButtons}
            </ul >

            <div>
                <Switch>
                    <Route exact path="/user/top">
                        <Top />
                    </Route>
                </Switch>
            </div>
        </>
    )
}

export default UserRouter;