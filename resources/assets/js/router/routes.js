import Route from 'vue-routisan';
import { auth, guest } from './guards';

Route.view('/', 'Home');

Route.group({ guard: guest }, () => {
    Route.view('/signup', 'auth/Signup');
    Route.view('/signin', 'auth/Signin');
    Route.view('/password/reset', 'auth/Email');
    Route.view('/password/reset/:token', 'auth/Reset');
});

Route.view('/user/:username', 'Profile');

Route.group({ guard: auth }, () => {
    Route.view('/search', 'SearchResults');
    Route.view('/friends', 'Friends');
});

Route.view('*', 'errors/404');

export default Route.all();
