import { throttle } from './helpers';

class ReportMenu {
  constructor() {
    this.$body = $('body');
    this.$reportToggle = $('.header__toggle--report');
    this.$reportMenu = $('.menu-report');
    this.$content = $('.l--content');

    if (this.$body.hasClass('single-topical_post')) {
      this.init();
    }
  }

  init() {
    this.$reportToggle.on('click.report-menu', this.showReportMenu.bind(this));
    this.$content.on('click.close-menu', this.closeMenu.bind(this));
  }

  deinit() {
    this.$reportToggle.off('click.report-menu');
    this.$content.off('click.close-menu');
  }

  closeMenu() {
    if (this.$body.hasClass('js-menu-active')) {
      this.showReportMenu();
    }
  }

  showReportMenu() {
    this.$body.toggleClass('js-menu-active');
    this.$body.toggleClass('js-no-scroll');
  }
}

export default ReportMenu;
