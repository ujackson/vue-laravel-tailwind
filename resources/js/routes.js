export default [
    { path: '/', component: require('./views/pages/Index.vue').default },
    { path: '/login', component: require('./views/auth/Login.vue').default },
    { path: '/register', component: require('./views/auth/Register.vue').default },
    { path: '/email/verification/:uuid', name: 'verify', component: require('./views/auth/Verify.vue').default },
    { path: '/password/forgot', component: require('./views/auth/passwords/Email.vue').default },
    { path: '/password/reset/:token', component: require('./views/auth/passwords/Reset.vue').default },
    { path: '/home', component: require('./views/pages/Home.vue').default,  meta: { requiresAuth: true } },
    { path: '/profile', component: require('./views/pages/Profile.vue').default,  meta: { requiresAuth: true } },
    { path: '/logout', component: require('./components/base/Logout.vue').default,  meta: { requiresAuth: true } },   
    { path: '*', component: require('./views/pages/404.vue').default } 
  ];
