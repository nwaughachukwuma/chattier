import Route from 'vue-routisan';
import { auth, guest } from './guards';

Route.view('/', 'Home');

Route.group({ guard: guest }, () => {
    Route.view('/signup', 'Auth/Signup');

    Route.view('/signin', 'Auth/Signin');

    Route.view('/password/reset', 'Auth/Passwords/Email');

    Route.view('/password/reset/:token', 'Auth/Passwords/Reset');
});

Route.view('/user/:username', 'Profile/Show');

Route.group({ guard: auth }, () => {
    Route.view('/profile/edit', 'Profile/Edit');

    Route.view('/password/change', 'Auth/Passwords/Change');

    Route.view('/search', 'SearchResults');

    Route.view('/friends', 'Friends');
});

Route.view('*', 'Errors/404');

export default Route.all();
