import { throttle } from './helpers';

class ToggleClass {
  constructor() {
    this.$window = $(window);
    this.$body = $('body');
    this.toggleElements = $('.js-toggle-class');

    if (this.toggleElements.length) {
      this.init();
    }
  }

  init() {
    this.toggleElements.on('click.toggle', this.onClick.bind(this));
    this.$window.on('resize.toggle', throttle.bind(this, this.removeActiveMenu));
  }

  deinit() {
    this.toggleElements.off('click.toggle');
    this.$window.off('resize.toggle');
  }

  removeActiveMenu() {
    if (this.$body.hasClass('js-menu-active')) {
      this.$body.removeClass('js-menu-active js-no-scroll');
    }
  }

  onClick(e) {
    let $this = $(e.target).closest('.js-toggle-class');
    let tClass = $this.data('t-class');
    let tElemPos = $this.data('t-elem-pos');
    let tSelector = $this.data('t-selector');

    switch (tElemPos) {
      case 'child':
      this.toggle($this.children(tSelector), tClass)
      break;
      case 'parent':
      this.toggle($this.closest(tSelector), tClass)
      break;
      default:
      this.toggle($this, tClass);
      break;
    }
  }

  toggle(el, tclass) {
    $(el).toggleClass(tclass);
  }
}

export default ToggleClass;
