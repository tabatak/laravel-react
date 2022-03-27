import Top from './Top';
import About from './About';

const routes = [
    { path: '/admin', exact: true, name: 'Admin' },
    { path: '/admin/top', exact: true, name: 'Top', component: Top },
    { path: '/admin/about', exact: true, name: 'About', component: About },
];
export default routes;
