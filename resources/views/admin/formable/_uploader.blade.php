<div id="myndasafn">
	<form action="/file-upload"
	      class="dropzone"
	      id="formable-image-uploader">
	      {!! csrf_field() !!}
	      <input type="hidden" name="model" value="{!! strtolower(trim($item->modelName())) !!}">
	      <input type="hidden" name="id" value="{!! (int)$item->id !!}">
	</form>

	<div v-if="isUploading" class="uk-margin-top uk-margin-bottom"><i class="uk-icon-large uk-icon-spin uk-icon-refresh uk-margin-right"></i>Augnablik...</div>

	<h3>Myndasafn</h3>
	<p v-if="! images.length">Engar myndir komnar inn.</p>
	<p>Eftir að búið er að upphala myndum í reitinn hér að ofan, þá birtast þær í listanum hér að neðan.</p>
	<ul class="uk-sortable images uk-grid uk-grid-small uk-grid-width-medium-1-4 uk-grid-width-large-1-6 uk-grid-width-small-1-3" v-class="disable-pointer-events: isUploading" data-uk-sortable>
		<li class="uk-grid-margin" v-repeat="image: images" style="cursor: move;" data-file-name="@{{ image.name }}" data-file-title="@{{ image.title }}">
			<div v-if="image.name" class="uk-panel uk-panel-box">
				<div>
					<img v-if="image.name" v-attr="src: '/imagecache/medium/' + image.name" />
				</div>
				<div>
					<small>@{{ image.title }}</small><br>
					<a v-on="click: deleteImage($index)"><i class="uk-icon-trash-o"></i></a>
				</div>
			</div>
		</li>
	</ul>
</div>

<script>
	window.sortableimages = UIkit.sortable($('ul.uk-sortable.images'), {});

	var imageView = new Vue({
		el: '#myndasafn',

		data: {
			isUploading: false,

			images: [],

			item: {
				model: $('input[name=model]').val(),
				id: $('input[name=id]').val()
			}
		},

		ready: function() {
			var self = this;

			this.updateImageList();

			$('#myndasafn').on('stop.uk.sortable', function() {
				self.isUploading = true;
				self.reorderImages();
			});

		

			Dropzone.options.formableImageUploader = {
				init: function() {
					this.on("addedfile", function(file) {
						console.log('added file');
						self.isUploading = true;
					});

					this.on("complete", function(file) {
						console.log('complete');
						self.updateImageList();
						self.isUploading = false;
					});

					this.on("removedfile", function(file) {
						//alert("Removed file.");
					});
				},

				dictCancelUploadConfirmation: 'Ertu viss um að þú viljir hætta við?',
				dictMaxFilesExceeded: 'Ekki var hægt að bæta við fleiri skrám í þessari lotu!',
				dictRemoveFile: 'Skrá var fjarlægð!',
				dictCancelUpload: 'Hætt var við upphalningu!',
				dictResponseError: 'Villa kom upp!',
				dictInvalidFileType: 'Þessi skrá er ekki leyfileg!',
				dictFileTooBig: 'Myndin er of stór!',
				dictDefaultMessage: 'Dragðu myndir yfir í þennan reit til að setja inn.',
				url: '/admin/formable/_uploadImage',
				paramName: "photo",
				maxFilesize: 2,
				acceptedFiles: '.jpg, .jpeg, .png, .gif',
				
				accept: function(file, done) {
					self.updateImageList();
					done();
				}
			};
		},
		
		methods: {
			deleteImage: function(idx) {
				var self = this;

				var data = {
					model: $('input[name=model]').val(),
					id: $('input[name=id]').val(),
					idx: idx
				};

				UIkit.modal.confirm("Ertu viss um að þú viljir eyða?", function() {
					self.isUploading = true;

		   			self.$http.post('/admin/formable/_deleteImage', data, function (data, status, request) {
						self.updateImageList();
					});
				});
			},

			reorderImages: function() {
				var self = this;				

				var newImagesList = [];

				$.each($('ul.uk-sortable.images').find('li'), function(i, v) {
					var name = $(v).attr('data-file-name');
					var title = $(v).attr('data-file-title');
					newImagesList.push({name: name, title: title});
				});

				console.log(newImagesList);

				if(newImagesList.length > 0) {
					var item = {
						model: $('input[name=model]').val(),
						id: $('input[name=id]').val(),
						images: newImagesList
					};

		   			this.$http.post('/admin/formable/_reorderImages', item, function (data, status, request) {
						console.log('done');
						self.updateImageList();
					});
				}
			},

			updateImageList: function() {
				var self = this;

				this.$http.post('/admin/formable/_images', self.item, function (data, status, request) {
					self.isUploading = false;
					this.$set('images', data);
				});
			}
		}
	});
</script>