class Topics {
  constructor() {
    this.$window        = $(window);
    this.$topicSelector = $('.js-topics-list-mobile');
    this.$topicsList    = $('.js-topics-list');
    this.$topicButtons  = $('.js-topic-list-button');
    this.$question      = $('.js-topic-question-heading');
    this.$voteButton    = $('.js-topic-vote-button');
    this.isDesktop      = this.$window.innerWidth() > 767;

    if ($('body').hasClass('page-template-template-landing')) {
      this.init();
    }
  }

  init() {
    this.$topicButtons.click(this.setTopic.bind(this));
    this.$topicSelector.on('change', this.setTopicMobile.bind(this));

    if (this.isDesktop) {
      this.$topicSelector.attr('aria-hidden', 'true');
      this.$topicsList.attr('aria-hidden', 'false');
    } else {
      this.$topicSelector.attr('aria-hidden', 'false');
      this.$topicsList.attr('aria-hidden', 'true');
    }

    this.$voteButton.click(this.sendVoteValue.bind(this));
  }

  deinit() {
    this.$topicButtons.off('click');
    this.$voteButton.off('click');
  }

  setTopic(e) {
    let $topicButton = $(e.target);
    let question = $topicButton.data('question');
    let topic = $topicButton.text();

    this.$topicButtons.attr('disabled', false);

    this.$topicButtons.removeClass('js-topic-list-button--active');
    $topicButton.addClass('js-topic-list-button--active');

    this.setVoteValue(topic);
    this.showQuestion(question);

    this.disableClickedTopic($topicButton);
  }

  setTopicMobile(e) {
    let $selectedTopic = this.$topicSelector.find(':selected');
    let question = $selectedTopic.data('question');
    let topic = $selectedTopic.val();

    this.setVoteValue(topic);
    this.showQuestion(question);
  }

  setVoteValue(topic) {
    this.$voteButton.data('vote', topic);
    this.$voteButton.attr('disabled', false);
  }

  showQuestion(question) {
    this.$question.text(question);
  }

  disableClickedTopic($clickedTopicButton) {
    $clickedTopicButton.attr('disabled', true);
    this.$voteButton.removeClass('js-topic-vote-button--active');
  }

  sendVoteValue() {
    if (ga) {
      let topic = this.$voteButton.data('vote');

      ga('send', 'event', 'topic-interest', 'vote', topic, {
        nonInteraction: true
      });

      this.$voteButton.attr('disabled', true);
      this.$voteButton.addClass('js-topic-vote-button--active');
    }
  }
}

export default Topics
