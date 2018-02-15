export default class User {
    constructor (user) {
        Object.assign(this, user);
    }

    fullname () {
        return `${this.firstname} ${this.lastname}`;
    }

    profile () {
        return `/user/${this.username}`;
    }
}
