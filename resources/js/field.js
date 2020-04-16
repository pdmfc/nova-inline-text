Nova.booting((Vue, router, store) => {
  Vue.component('index-nova-inline-text', require('./components/IndexField'));
  Vue.component('detail-nova-inline-text', require('./components/DetailField'));
  Vue.component('form-nova-inline-text', require('./components/FormField'));
});
