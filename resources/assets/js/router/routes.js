import Route from 'vue-routisan';
import { auth, guest } from './guards';

Route.view('/', 'Home');

Route.group({ guard: guest }, () => {
    Route.view('/signup', 'Signup');
    Route.view('/signin', 'Signin');
    Route.view('/password/reset', 'Email');
    Route.view('/password/reset/:token', 'Reset');
});

Route.group({ guard: auth }, () => {
    Route.view('/search', 'SearchResults');
    Route.view('/friends', 'Friends');
});

export default Route.all();
