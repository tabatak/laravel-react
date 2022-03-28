import React from 'react';
import { Link, useHistory, Switch, Route } from 'react-router-dom';
import axios from 'axios';
import swal from 'sweetalert';

import Top from './Top';

function AdminRouter() {

    const history = useHistory();

    const logoutSubmit = (e) => {
        e.preventDefault();

        axios.post(`/api/admin/logout`).then(res => {
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

    AuthButtons = (
        <li>
            <div onClick={logoutSubmit}>
                <span>ログアウト</span>
            </div>
        </li>
    );

    return (
        <>
            Admin Page
            < ul >
                <li>
                    <Link to="/admin/top">
                        <span>Top</span>
                    </Link>
                </li>
                {AuthButtons}
            </ul >

            <div>
                <Switch>
                    <Route exact path="/admin/top">
                        <Top />
                    </Route>
                </Switch>
            </div>
        </>
    )
}

export default AdminRouter;