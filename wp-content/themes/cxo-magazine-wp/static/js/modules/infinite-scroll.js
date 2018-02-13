import { throttle } from './helpers';
import EventEmitter from './event-emitter';

class InfiniteScroll extends EventEmitter {
  constructor() {
    super();

    this.$window = $(window);
    this.$document = $(document);
    this.$body = $('body');
    this.scrollTrigger = 0.85;
    this.isLoading = false;
    this.lastScroll = this.$window.scrollTop();
    this.isScrollDown;

    if ($('.js-infinite-scroll').length) {
      this.init();
    }
  }

  init() {
    this.currentPostId = $('.js-infinite-scroll').last().data('post-id');
    this.isLast = $('.article-wrapper').last().hasClass('js-is-last');
    this.$window.on('scroll.infinite', throttle.bind(this, this.onScroll));
  }

  reinit() {
    this.$window = $(window);
    this.$document = $(document);
    this.scrollTrigger = 0.85;
    this.isLoading = false;
    this.lastScroll = this.$window.scrollTop();
    this.isScrollDown;

    if ($('.js-infinite-scroll').length) {
      this.init();
    }
  }

  deinit() {
    this.$window.off('scroll.infinite');
  }

  onScroll() {
    let scrollTop      = $(window).scrollTop();
    let documentHeight = $(document).height();
    let windowHeight   = $(window).height();

    this.getScrollDirection();

    if ((scrollTop / (documentHeight - windowHeight)) > this.scrollTrigger) {

      if (!this.isLast && !this.isLoading && this.isScrollDown) {
        this.getNextArticle();
        this.toggleLoadingClass();
      }
    }
  }

  getScrollDirection() {
    let currentScroll = this.$window.scrollTop();

    this.isScrollDown = currentScroll > this.lastScroll && currentScroll >= 1;

    this.lastScroll = currentScroll;
  }

  getNextArticle() {
    let _this = this;
    let postData = {
      action: 'infinite_load_next',
      current_post_id: this.currentPostId
    }

    this.isLoading = true;
    super.emit('modules:deinit');

    $.ajax({
      type: 'POST',
      url: ajax_url,
      data: postData,
      success: _this.onResponse.bind(_this)
    });
  }

  onResponse(res) {
    let responseObj = res ? JSON.parse(res) : res;

    this.loadNextArticle(responseObj);
  }

  loadNextArticle(responseObj) {
    let nextArticle = responseObj.next_article;
    $('.l--content').append(responseObj.compiled_html);

    this.resetState(nextArticle);
  }

  resetState(nextArticle) {
    this.currentPostId = nextArticle.id;
    this.isLoading = false;

    this.setActiveInMenu();
    this.setUrl(nextArticle.link, nextArticle.heading);
    this.toggleLoadingClass();
    super.emit('modules:init');
  }

  setUrl(link, pageTitle) {
    let urlObj = new URL(link);
    if (urlObj.origin !== window.location.origin) {
      link = link.replace(urlObj.origin, window.location.origin);
    }

    $('title').text(pageTitle);
    history.pushState(history.state, pageTitle, link);

    // Fire Google Analytics
    if (window.ga && ga.create) {
      ga('set', {page: link, title: pageTitle});
      ga('send', 'pageview');
    }
  }

  setActiveInMenu() {
    let menuItems = $('.menu-report__post-item');

    menuItems.removeClass('menu-report__post-item--active');
    let filteredMenu = menuItems.filter( (i, el) => {
      return $(el).data('post-id') === this.currentPostId;
    })

    filteredMenu.addClass('menu-report__post-item--active');
  }

  toggleLoadingClass() {
    this.$body.toggleClass('is-loading--infinite');
  }
}

export default InfiniteScroll;
