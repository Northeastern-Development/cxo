import 'babel-polyfill';
import CXO from './modules/cxo';
import ToggleClass from './modules/toggle-class';
import Landing from './modules/landing';
import Topics from './modules/topics';
import Newsletter from './modules/newsletter';
import ReportMenu from './modules/report-menu';

window.onload = () => {
  let modules = [
    ToggleClass,
    Landing,
    Topics,
    Newsletter,
    ReportMenu
  ]

  new CXO(modules);
}
