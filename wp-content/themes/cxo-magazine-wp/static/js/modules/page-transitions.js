import 'smoothstate';
import EventEmitter from './event-emitter';

class PageTransitions extends EventEmitter {
  constructor() {
    super();
    this.container = $('#pjax-container');
    this.options = {
      prefetch: false,
      forms: false,
      blacklist: '[href*="/wp-"], a[href$=".jpg"], a[href$=".jpeg"], a[href$=".png"], a[href$=".pdf"]',
      onStart: {
        duration: 650,
        render: this.onTransitionStarted.bind(this)
      },
      onReady: {
        duration: 400,
        render: this.onTransitionReady.bind(this)
      },
      onAfter: this.onTransitionAfter.bind(this)
    };

    this.init();
  }

  init() {
    this.smoothState = this.container.smoothState(this.options).data('smoothState');
  }

  onTransitionStarted($container) {
    super.emit('modules:deinit');
    $container.addClass('is-exiting');
    this.smoothState.restartCSSAnimations();
  }

  onTransitionReady($container, $newContent) {
    $container.removeClass('is-exiting');
    $container.html($newContent);
    this.copyBodyClasses();
  }

  onTransitionAfter() {
    super.emit('modules:init');

    // Announce page transition for assistive technologies.
    $('#pjax-announce').text('Navigated to page: ' + document.title);

    // Fire Google Analytics
    if (window.ga && ga.create) {
      ga('set', {page: window.location.pathname, title: document.title});
      ga('send', 'pageview');
    }
  }

  /**
   * Copy body classes from new page to current page.
   *
   * NOTE: This is hacky as Smooth State doesn't give us a good way to access HTML content loaded
   * outside of the container.
   */
  copyBodyClasses() {
    // The href property is set prior to the `onReady` action to the URL of the page being loaded
    var url = this.smoothState.href,
      doc, matches, classes;

    // Pages objects are indexed in the smoothState cache by href.
    // Currently it's the only way to get at the raw response document.
    if (url in this.smoothState.cache) {
      // Smooth state stores the full HTML document string in the `doc` property of the cached page object.
      doc = this.smoothState.cache[url].doc || false;
      if (doc) {
        // Brute force class extraction from the HTML string.
        matches = doc.match( /<body.*class=['"](.*)['"]/ );
        if (matches) {
          classes = matches[1];
        }
      }
    }

    // Replace body classes if we were able to extract them.
    if (classes) {
      $('body').attr('class', classes);
    }
  }
}

export default PageTransitions;

