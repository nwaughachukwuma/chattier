class Flash {
    constructor () {
        this._config = {
            handler: (message) => alert(message),
            extract: 'flash',
            bus: 'eventBus',
            event: 'flash'
        };
    }

    setConfig (customConfig) {
        Object.assign(this._config, customConfig);
    }

    show (message, options = null) {
        this.emitter(message, options);
    }

    interceptor (data, options = null) {
        if (data.hasOwnProperty(this._config.extract)) {
            const message = data[this._config.extract];
            this.emitter(message, options);
        }
    }

    emitter (message, options) {
        const config = this._config;
        setTimeout(() => {
            window[config.bus].$emit(config.event, message, options);
        }, 100);
    }

    listener () {
        window[this._config.bus].$on(this._config.event, this._config.handler);
    }
}

export default new Flash();
