function throttle(func) {
  if (this.ticking) {
    window.requestAnimationFrame( () => {
      func.call(this);
      this.ticking = false;
    });
  }
  this.ticking = true;
}

export { throttle };
