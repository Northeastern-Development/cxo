import 'smoothstate';
import PageTransitions from './page-transitions';
import InfiniteScroll from './infinite-scroll';

class CXO {
  constructor(moduleArr) {
    this.moduleArr = moduleArr;
    this.initializedModulesArr = [];
    this.observables = [];

    this.init();
  }

  init() {
    this.initModules();
    this.observables.push(new PageTransitions());

    $.each(this.observables, (i, observable) => {
      observable.addListener('modules:init', this.initModules.bind(this));
      observable.addListener('modules:deinit', this.deinitModules.bind(this));
    });
  }

  initModules() {
    $.each(this.moduleArr, (i, mod) => {
      if (mod.name === 'Newsletter') {
        const forms = $('.newsletter-form');

        forms.each( (i, el) => {
          this.initializedModulesArr.push(new mod(el));
        });
      } else {
         this.initializedModulesArr.push(new mod());
      }
    });

    this.infiniteScrollInit();
  }

  infiniteScrollInit() {
    if (this.findModule(this.observables, 'InfiniteScroll')) {
      this.findModule(this.observables, 'InfiniteScroll').reinit();
    } else {
      let infiniteScrollMod = new InfiniteScroll();
      this.observables.push(infiniteScrollMod);
    }
  }

  deinitModules() {
    this.initializedModulesArr.map( initializedMod => {
      initializedMod.deinit();
    });

    if (this.findModule(this.observables, 'InfiniteScroll')) {
      this.findModule(this.observables, 'InfiniteScroll').deinit();
    }

    this.initializedModulesArr = [];
  }

  findModule(modArr, moduleName) {
    return modArr.find(mod => {
      return mod.constructor.name === moduleName;
    });
  }
}

export default CXO;

