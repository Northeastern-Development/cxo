import Flickity from 'flickity';

class Landing {
  constructor() {
    this.$window = $(window);
    this.$body = $('body');
    this.$headerSubscribe = $('.landing-page-header__share-list-item--subscribe-button');

    if (this.$body.hasClass('page-template-template-landing')) {
      this.init();
    }
  }

  init() {
    var _this = this;
    this.$headerSubscribe.on('click', this.scrollToSubscribe.bind(this));

    setTimeout(() => {
      _this.carousel = _this.setupCarousel();
      _this.carousel.on('select', _this.updateSlideIndex.bind(_this, _this.carousel));
    }, 300);
  }

  deinit() {
    this.$headerSubscribe.off('click');

    if (this.carousel) {
      $('.flickity-prev-next-button').appendTo('.landing-carousel');

      this.carousel.destroy();
    }
  }

  setupCarousel() {
    let carousel = new Flickity('.landing-carousel', {
      autoPlay: 5000,
      cellSelector: '.landing-hero',
      cellAlign: 'left',
      pageDots: false,
      wrapAround: true,
      arrowShape: 'M16.804543,45.3699045 L100,45.3699045 L100,53.7032378 L16.6158612,53.7032378 L47.8912639,84.9786406 L41.6233015,91.246603 L6.27557302,55.8988745 L-1.42108547e-13,49.6233015 L41.6233015,8 L47.8988745,14.275573 L16.804543,45.3699045 Z'
    });

    $('.landing-carousel').append('<div class="carousel-pagination-wrapper"><p class="landing-hero__post-number"></p></div>');
    let postNumber = $('.landing-hero__post-number');

    $('.flickity-prev-next-button.previous').insertBefore(postNumber);
    $('.flickity-prev-next-button.next').insertAfter(postNumber);

    this.updateSlideIndex(carousel);

    return carousel
  }

  updateSlideIndex(carousel) {
    var slideNumber = carousel.selectedIndex + 1;

    let activeSlide = `<span class="landing-hero__post-number--active">${slideNumber} </span>`
    let totalSlides = `<span class="landing-hero__post-number--total">/ ${carousel.slides.length}</span>`

    $('.landing-hero__post-number').html(activeSlide + totalSlides);
  }

  scrollToSubscribe(e) {
    e.preventDefault();
    const subscribeForm = $('.landing-about__subscribe');

    $('html, body').animate({
      scrollTop: subscribeForm.offset().top
    }, 300);
  }
}

export default Landing
