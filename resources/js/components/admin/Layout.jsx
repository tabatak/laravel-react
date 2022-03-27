import React from 'react';
import { Redirect, Route, Switch } from 'react-router-dom';

import routes from './routes';

const Layout = () => {
    return (
        <div>
            <h1>Admin Pages</h1>
            <div>
                <main>
                    <Switch>
                        {routes.map((route, idx) => {
                            return (
                                route.component && (
                                    <Route
                                        key={idx}
                                        path={route.path}
                                        exact={route.exact}
                                        name={route.name}
                                        render={(props) => (
                                            <route.component {...props} />
                                        )}
                                    />
                                )
                            )
                        })}
                        <Redirect from="admin" to="/admin/top" />
                    </Switch>
                </main>
            </div>
        </div>
    )
};
export default Layout;