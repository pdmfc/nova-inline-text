<template>
  <div>
    <input
      v-if="field.inlineOnIndex"
      :id="fieldId"
      type="text"
      class="w-full form-control form-input form-input-bordered"
      :class="errorClasses"
      :placeholder="field.name"
      v-model="value"
      v-on="listener"
      :disabled="field.readonly"
    />
    <span v-else class="whitespace-no-wrap">{{ field.value }}</span>
  </div>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova';

export default {
  mixins: [FormField, HandlesValidationErrors],

  props: ['resourceName', 'field'],

  methods: {
    submit() {
      let formData = new FormData();

      formData.append(this.field.attribute, this.value);
      formData.append('_method', 'PUT');

      return Nova.request()
        .post(
          `/nova-api/${this.resourceName}/${this.$parent.resource.id.value}`,
          formData
        )
        .then(
          () => {
            this.$toasted.show(`${this.field.name} updated`, {
              type: 'success',
            });

            this.refreshTable();
          },
          (response) => this.$toasted.show(response, { type: 'error' })
        );
    },

    refreshTable() {
      if (this.shouldRefresh) {
        this.$parent.$parent.$parent.$parent.$parent.$parent.getResources();
      }
    },

    capitalize(string) {
      return string.charAt(0).toUpperCase() + string.substr(1);
    },
  },

  computed: {
    resourceId() {
      return this.$parent.resource.id.value;
    },

    fieldId() {
      return `inline-text-field-${this.field.name}-${this.resourceId}`;
    },

    shouldRefresh() {
      return this.field.refreshOnSaving;
    },

    listener() {
      const event = this.field.event.split('.');
      const name = event[0];
      const modifier = event[1] ? this.capitalize(event[1]) : null;

      return {
        [name]: (e) => {
          if (this.valueWasNotChanged) return;

          if (modifier && modifier === e.key) this.submit();

          if (!modifier) this.submit();
        },
      };
    },

    valueWasNotChanged() {
      return this.value === this.field.value;
    },
  },
};
</script>
