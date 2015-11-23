<div v-cloak id="admin-product-options">

	<div v-repeat="option: options" class="uk-margin-bottom">
		<div class="uk-panel uk-panel-box uk-panel-box-primary">
			<form class="uk-form uk-form-stacked"
				  v-on="submit: onSubmit">
				<div class="uk-grid uk-grid-small" data-uk-grid-margin>
					<div class="uk-width-9-10">
						<input class="uk-form-large uk-form-controls uk-width-1-1" v-model="option.text" placeholder="Valflokkaheiti" />
					</div>

					<div class="uk-width-1-10">
						<a v-on="click: removeOption($index)"><i class="uk-icon-medium uk-icon-remove"></i></a>
					</div>
				</div>

				<div v-if="option.values.length > 0 || option.text.length > 0" class="uk-margin-top">
					<div class="uk-grid uk-grid-small" data-uk-grid-margin v-repeat="value: option.values">
						<div class="uk-width-7-10">
							<input class="uk-form-small uk-width-1-1" v-model="value.text" placeholder="Valmöguleiki">
						</div>

						<div class="uk-width-2-10">
							<input class="uk-form-small uk-width-1-1" v-model="value.modifier" placeholder="Mismunur (+/-)">
						</div>

						<div class="uk-width-1-10">
							<a v-on="click: removeSubOption($parent.$index, $index)"><i class="uk-icon-small uk-icon-remove"></i></a>
						</div>
					</div>

					<button class="uk-button uk-margin-top uk-button-small" v-on="click: addSubOption($index)">Nýr valmöguleiki<i class="uk-icon-plus uk-margin-left"></i></button>
				</div>
			</form>
		</div>
	</div>

	<button class="uk-button uk-margin-bottom uk-button-primary" v-on="click: addOption">Nýr valflokkur<i class="uk-icon-plus uk-margin-left"></i></button>
	<button class="uk-button uk-margin-bottom uk-button-success uk-margin-left"
			v-on="click: saveOptions">Vista breytingar<i class="uk-icon-save uk-margin-left"></i></button>

	<div class="uk-clearfix"></div>

	<p v-if="saving"><i class="uk-icon-spin uk-icon-spinner"></i> Vista...</p>

	
	<pre>
	@{{ options | json }}
	</pre>
	
</div>

<script>
new Vue({
	el: '#admin-product-options',

	data: {
		saving: false,
		changed: false,
		options: []
	},

	ready: function() {
		this.$http.get('/_product/{{ $item->id }}', function(data, status, error) {
			self.optionCount = data.length;

			this.$set('options', data);
		});
	},

	methods: {
		onChange: function() {
			this.changed = true;
		},

		saveOptions: function() {
			this.saving = true;

			var self = this;

			var data = {
				options: this.options
			};

			$.each(self.options, function(i, v) {
				if(!v.text.length) {
					v.values = [];
				}
			});

			this.$http.post('/_product/{{ $item->id }}/save-options', data, function(data, status, error) {
				self.optionCount = data.length;
				this.$set('options', data);
				self.saving = false;
			});
		},

		onSubmit: function(e) {
			e.preventDefault();
		},

		addOption: function() {
			var newOption = this.newOption;

			this.options.push({
				text: '',
				type: 'select',
				values: []
			});
		},

		removeOption: function($idx) {
			this.options.$remove($idx);
		},

		addSubOption: function($idx) {
			var newValue = this.newValue;

			this.options[$idx].values.push({
				text: '',
				value: '',
				modifier: ''
			});
		},

		removeSubOption: function($parIdx, $subIdx) {
			this.options[$parIdx].values.$remove($subIdx);
		}
	}
});
</script>