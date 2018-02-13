let isFunction = function(obj) {
  return typeof obj == 'function' || false;
};

class EventEmitter {
  constructor() {
    this.listeners = new Map();
  }

  addListener(evtName, cb) {
    this.listeners.has(evtName) || this.listeners.set(evtName, []);
    this.listeners.get(evtName).push(cb);
  }

  emit(evtName, ...args) {
    let listeners = this.listeners.get(evtName);

    if (listeners && listeners.length) {
      listeners.forEach((listener) => {
        listener(...args);
      });
      return true;
    }
    return false;
  }
}

export default EventEmitter;
