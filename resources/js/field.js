import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
    app.component('index-nova-inline-text', IndexField)
    app.component('detail-nova-inline-text', DetailField)
    app.component('form-nova-inline-text', FormField)
})
