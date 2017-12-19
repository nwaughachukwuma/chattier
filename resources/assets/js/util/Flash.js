class Flash {
    constructor () {
        this._config = {
            mode: 'extract', // 'extract'|'direct'
            key: 'flash',
            event: 'flash',
            busName: 'eventBus',
            handler: (message) => alert(message)
        };
    }

    setCustomConfig (customConfig) {
        Object.keys(this._config).forEach((key) => {
            this._config[key] = (customConfig.hasOwnProperty(key) ? customConfig : this._config)[key];
        });
    }

    emitter (data, options = null) {
        if (this._config.mode === 'extract') {
            if (data.hasOwnProperty(this._config.key)) {
                window[this._config.busName].$emit(this._config.event, data[this._config.key], options);
            }
        } else if (this._config.mode === 'direct') {
            window[this._config.busName].$emit(this._config.event, data, options);
        }
    }

    listener () {
        window[this._config.busName].$on(this._config.event, this._config.handler);
    }
}

export { Flash };
export default new Flash();
